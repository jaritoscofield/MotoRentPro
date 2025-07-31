<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentInstallment;
use App\Models\Client;
use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['client', 'motorcycle', 'installments']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('client', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('motorcycle', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('license_plate', 'like', "%{$search}%");
                });
            });
        }

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sale_type')) {
            $query->where('sale_type', $request->sale_type);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->where('sale_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('sale_date', '<=', $request->date_to);
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $payments = $query->paginate(10);

        // Buscar parcelas de pagamento para a aba de pagamentos com filtros
        $paymentInstallmentsQuery = PaymentInstallment::with(['payment.client', 'payment.motorcycle']);

        // Aplicar filtros se fornecidos
        if ($request->filled('search')) {
            $search = $request->search;
            $paymentInstallmentsQuery->where(function($query) use ($search) {
                $query->whereHas('payment.client', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('payment.motorcycle', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('license_plate', 'like', "%{$search}%");
                })
                ->orWhere('installment_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $paymentInstallmentsQuery->where('status', $request->status);
        }

        if ($request->filled('due_date_from')) {
            $paymentInstallmentsQuery->where('due_date', '>=', $request->due_date_from);
        }

        if ($request->filled('due_date_to')) {
            $paymentInstallmentsQuery->where('due_date', '<=', $request->due_date_to);
        }

        if ($request->filled('amount_from')) {
            $paymentInstallmentsQuery->where('amount', '>=', $request->amount_from);
        }

        if ($request->filled('amount_to')) {
            $paymentInstallmentsQuery->where('amount', '<=', $request->amount_to);
        }

        $paymentInstallments = $paymentInstallmentsQuery->orderBy('due_date', 'asc')->get();
        
        // Log para debug
        \Log::info('PaymentInstallments encontrados:', [
            'count' => $paymentInstallments->count(),
            'data' => $paymentInstallments->toArray()
        ]);

        // Statistics
        $stats = [
            'total_revenue' => Payment::sum('total_amount'),
            'total_received' => Payment::where('status', 'concluida')->sum('total_amount'),
            'pending_amount' => Payment::where('status', 'ativa')->sum('total_amount'),
            'overdue_amount' => Payment::where('status', 'ativa')
                ->where('due_date', '<', now())
                ->sum('total_amount'),
            'active_sales' => Payment::where('status', 'ativa')->count(),
            'total_sales' => Payment::count(),
        ];

        // Weekly Sales Statistics
        $weeklySalesCount = Payment::where('status', 'ativa')
            ->where('periodicity', 'semanal')
            ->count();

        $weeklyRevenue = Payment::where('status', 'ativa')
            ->where('periodicity', 'semanal')
            ->sum('total_amount');

        // Calculate weekly paid amount (sum of paid installments for weekly payments)
        $weeklyPaid = PaymentInstallment::whereHas('payment', function($query) {
                $query->where('status', 'ativa')
                      ->where('periodicity', 'semanal');
            })
            ->where('status', 'pago')
            ->sum('amount');

        // Calculate weekly pending amount (sum of pending installments for weekly payments)
        $weeklyPending = PaymentInstallment::whereHas('payment', function($query) {
                $query->where('status', 'ativa')
                      ->where('periodicity', 'semanal');
            })
            ->where('status', 'pendente')
            ->sum('amount');

        return view('modules.payments.index', compact('payments', 'stats', 'paymentInstallments', 'weeklySalesCount', 'weeklyRevenue', 'weeklyPaid', 'weeklyPending'));
    }

    public function create()
    {
        $clients = Client::where('status', 'Ativo')->get();
        $motorcycles = Motorcycle::where('status', 'Disponível')->get();
        
        $saleTypes = [
            'venda' => 'Venda',
            'aluguel' => 'Aluguel'
        ];

        $paymentMethods = [
            'dinheiro' => 'Dinheiro',
            'cartao_credito' => 'Cartão de Crédito',
            'cartao_debito' => 'Cartão de Débito',
            'pix' => 'PIX',
            'transferencia' => 'Transferência'
        ];

        $statuses = [
            'ativa' => 'Ativa',
            'concluida' => 'Concluída',
            'cancelada' => 'Cancelada',
            'pendente' => 'Pendente'
        ];

        $periodicities = [
            'semanal' => 'Semanal',
            'mensal' => 'Mensal'
        ];

        return view('modules.payments.create', compact('clients', 'motorcycles', 'saleTypes', 'paymentMethods', 'statuses', 'periodicities'));
    }

    public function store(Request $request)
    {
        // Log para debug
        \Log::info('Dados recebidos na criação de venda:', $request->all());
        
        try {
            $request->validate([
                'client_id' => 'required|exists:clients,id',
                'motorcycle_id' => 'required|exists:motorcycles,id',
                'sale_type' => 'required|in:venda,aluguel',
                'total_amount' => 'required|numeric|min:0',
                'down_payment' => 'required|numeric|min:0',
                'installments' => 'required|integer|min:1',
                'periodicity' => 'required|in:semanal,mensal',
                'payment_method' => 'required|in:dinheiro,cartao_credito,cartao_debito,pix,transferencia',
                'status' => 'required|in:ativa,concluida,cancelada,pendente',
                'sale_date' => 'required|date',
                'due_date' => 'nullable|date|after_or_equal:sale_date',
                'notes' => 'nullable|string'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erro de validação na criação de venda:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }

        DB::beginTransaction();
        try {
            $payment = Payment::create([
                'client_id' => $request->client_id,
                'motorcycle_id' => $request->motorcycle_id,
                'sale_type' => $request->sale_type,
                'total_amount' => $request->total_amount,
                'down_payment' => $request->down_payment,
                'installments' => $request->installments,
                'periodicity' => $request->periodicity,
                'installment_amount' => $request->installments > 1 ? 
                    ($request->total_amount - $request->down_payment) / $request->installments : 0,
                'payment_method' => $request->payment_method,
                'status' => $request->status,
                'sale_date' => $request->sale_date,
                'due_date' => $request->due_date,
                'notes' => $request->notes
            ]);

            // Create installments if more than 1
            if ($request->installments > 1) {
                $installmentAmount = ($request->total_amount - $request->down_payment) / $request->installments;
                $dueDate = Carbon::parse($request->sale_date)->addMonth();

                for ($i = 1; $i <= $request->installments; $i++) {
                    PaymentInstallment::create([
                        'payment_id' => $payment->id,
                        'installment_number' => $i,
                        'amount' => $installmentAmount,
                        'due_date' => $dueDate->copy()->addMonths($i - 1),
                        'status' => 'pendente'
                    ]);
                }
            }

            // Update motorcycle status if it's a sale
            if ($request->sale_type === 'venda') {
                $motorcycle = Motorcycle::find($request->motorcycle_id);
                $motorcycle->update(['status' => 'Vendida']);
            }

            DB::commit();
            return redirect('/pagamentos')->with('success', 'Venda criada com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Erro ao criar venda: ' . $e->getMessage()]);
        }
    }

    public function show(Payment $payment)
    {
        $payment->load(['client', 'motorcycle', 'installments']);
        return view('modules.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $clients = Client::where('status', 'Ativo')->get();
        $motorcycles = Motorcycle::all();
        
        $saleTypes = [
            'venda' => 'Venda',
            'aluguel' => 'Aluguel'
        ];

        $paymentMethods = [
            'dinheiro' => 'Dinheiro',
            'cartao_credito' => 'Cartão de Crédito',
            'cartao_debito' => 'Cartão de Débito',
            'pix' => 'PIX',
            'transferencia' => 'Transferência'
        ];

        $statuses = [
            'ativa' => 'Ativa',
            'concluida' => 'Concluída',
            'cancelada' => 'Cancelada',
            'pendente' => 'Pendente'
        ];

        $periodicities = [
            'semanal' => 'Semanal',
            'mensal' => 'Mensal'
        ];

        return view('modules.payments.edit', compact('payment', 'clients', 'motorcycles', 'saleTypes', 'paymentMethods', 'statuses', 'periodicities'));
    }

    public function update(Request $request, Payment $payment)
    {
        // Log para debug
        \Log::info('Dados recebidos na atualização de venda:', $request->all());
        
        try {
            $request->validate([
                'client_id' => 'required|exists:clients,id',
                'motorcycle_id' => 'required|exists:motorcycles,id',
                'sale_type' => 'required|in:venda,aluguel',
                'total_amount' => 'required|numeric|min:0',
                'down_payment' => 'required|numeric|min:0',
                'installments' => 'required|integer|min:1',
                'periodicity' => 'required|in:semanal,mensal',
                'payment_method' => 'required|in:dinheiro,cartao_credito,cartao_debito,pix,transferencia',
                'status' => 'required|in:ativa,concluida,cancelada,pendente',
                'sale_date' => 'required|date',
                'due_date' => 'nullable|date|after_or_equal:sale_date',
                'notes' => 'nullable|string'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Erro de validação na atualização de venda:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }

        DB::beginTransaction();
        try {
            $payment->update([
                'client_id' => $request->client_id,
                'motorcycle_id' => $request->motorcycle_id,
                'sale_type' => $request->sale_type,
                'total_amount' => $request->total_amount,
                'down_payment' => $request->down_payment,
                'installments' => $request->installments,
                'periodicity' => $request->periodicity,
                'installment_amount' => $request->installments > 1 ? 
                    ($request->total_amount - $request->down_payment) / $request->installments : 0,
                'payment_method' => $request->payment_method,
                'status' => $request->status,
                'sale_date' => $request->sale_date,
                'due_date' => $request->due_date,
                'notes' => $request->notes
            ]);

            // Update installments if needed
            if ($request->installments > 1) {
                // Delete existing installments
                $payment->installments()->delete();
                
                // Create new installments
                $installmentAmount = ($request->total_amount - $request->down_payment) / $request->installments;
                $dueDate = Carbon::parse($request->sale_date)->addMonth();

                for ($i = 1; $i <= $request->installments; $i++) {
                    PaymentInstallment::create([
                        'payment_id' => $payment->id,
                        'installment_number' => $i,
                        'amount' => $installmentAmount,
                        'due_date' => $dueDate->copy()->addMonths($i - 1),
                        'status' => 'pendente'
                    ]);
                }
            }

            DB::commit();
            return redirect('/pagamentos')->with('success', 'Venda atualizada com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Erro ao atualizar venda: ' . $e->getMessage()]);
        }
    }

    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();
            return redirect('/pagamentos')->with('success', 'Venda excluída com sucesso!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao excluir venda: ' . $e->getMessage()]);
        }
    }

    public function export()
    {
        $payments = Payment::with(['client', 'motorcycle'])->get();
        
        $filename = 'pagamentos_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            
            // Headers
            fputcsv($file, [
                'ID', 'Cliente', 'Motocicleta', 'Tipo', 'Valor Total', 
                'Entrada', 'Parcelas', 'Método', 'Status', 'Data Venda', 
                'Vencimento', 'Progresso (%)', 'Valor Restante'
            ]);

            // Data
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->id,
                    $payment->client->name,
                    $payment->motorcycle->name,
                    ucfirst($payment->sale_type),
                    $payment->formatted_total_amount,
                    $payment->formatted_down_payment,
                    $payment->installments,
                    ucfirst(str_replace('_', ' ', $payment->payment_method)),
                    ucfirst($payment->status),
                    $payment->formatted_sale_date,
                    $payment->formatted_due_date,
                    $payment->progress_percentage . '%',
                    $payment->formatted_remaining_amount
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function dashboard()
    {
        // Statistics for dashboard
        $stats = [
            'total_revenue' => Payment::sum('total_amount'),
            'total_received' => Payment::where('status', 'concluida')->sum('total_amount'),
            'pending_amount' => Payment::where('status', 'ativa')->sum('total_amount'),
            'overdue_amount' => Payment::where('status', 'ativa')
                ->where('due_date', '<', now())
                ->sum('total_amount'),
            'active_sales' => Payment::where('status', 'ativa')->count(),
            'total_sales' => Payment::count(),
        ];

        // Recent sales
        $recentSales = Payment::with(['client', 'motorcycle'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pending payments
        $pendingPayments = PaymentInstallment::with(['payment.client', 'payment.motorcycle'])
            ->where('status', 'pendente')
            ->where('due_date', '<', now())
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        return view('modules.payments.dashboard', compact('stats', 'recentSales', 'pendingPayments'));
    }

    public function reports(Request $request)
    {
        // Get filter parameters
        $period = $request->get('period', 30);
        $saleType = $request->get('sale_type');
        $status = $request->get('status');
        $paymentMethod = $request->get('payment_method');

        // Build query
        $query = Payment::with(['client', 'motorcycle']);

        // Apply filters
        if ($period && $period !== 'custom') {
            $query->where('sale_date', '>=', now()->subDays($period));
        }

        if ($saleType) {
            $query->where('sale_type', $saleType);
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($paymentMethod) {
            $query->where('payment_method', $paymentMethod);
        }

        // Get statistics
        $stats = [
            'total_revenue' => $query->sum('total_amount'),
            'total_received' => $query->where('status', 'concluida')->sum('total_amount'),
            'pending_amount' => $query->where('status', 'ativa')->sum('total_amount'),
            'overdue_amount' => $query->where('status', 'ativa')
                ->where('due_date', '<', now())
                ->sum('total_amount'),
            'active_sales' => $query->where('status', 'ativa')->count(),
            'total_sales' => $query->count(),
            'completed_sales' => $query->where('status', 'concluida')->count(),
            'overdue_sales' => $query->where('status', 'ativa')
                ->where('due_date', '<', now())
                ->count(),
            'venda_count' => $query->where('sale_type', 'venda')->count(),
            'aluguel_count' => $query->where('sale_type', 'aluguel')->count(),
        ];

        // Revenue chart data (last 12 months)
        $revenueChart = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthRevenue = $query->whereYear('sale_date', $date->year)
                ->whereMonth('sale_date', $date->month)
                ->sum('total_amount');
            
            $revenueChart['labels'][] = $date->format('M/Y');
            $revenueChart['data'][] = $monthRevenue;
        }

        // Payment methods statistics
        $paymentMethodsStats = [];
        $methods = [
            'dinheiro' => ['label' => 'Dinheiro', 'color' => '#10B981'],
            'cartao_credito' => ['label' => 'Cartão de Crédito', 'color' => '#3B82F6'],
            'cartao_debito' => ['label' => 'Cartão de Débito', 'color' => '#8B5CF6'],
            'pix' => ['label' => 'PIX', 'color' => '#F59E0B'],
            'transferencia' => ['label' => 'Transferência', 'color' => '#EF4444'],
        ];

        foreach ($methods as $method => $info) {
            $count = $query->where('payment_method', $method)->count();
            $percentage = $stats['total_sales'] > 0 ? round(($count / $stats['total_sales']) * 100, 1) : 0;
            
            $paymentMethodsStats[$method] = [
                'label' => $info['label'],
                'color' => $info['color'],
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        // Top clients
        $topClients = $query->selectRaw('client_id, COUNT(*) as total_sales, SUM(total_amount) as total_amount')
            ->groupBy('client_id')
            ->orderBy('total_amount', 'desc')
            ->limit(5)
            ->with('client')
            ->get()
            ->map(function ($item) {
                $item->name = $item->client->name;
                return $item;
            });

        // Top motorcycles
        $topMotorcycles = $query->selectRaw('motorcycle_id, COUNT(*) as total_sales, SUM(total_amount) as total_amount')
            ->groupBy('motorcycle_id')
            ->orderBy('total_amount', 'desc')
            ->limit(5)
            ->with('motorcycle')
            ->get()
            ->map(function ($item) {
                $item->name = $item->motorcycle->name;
                return $item;
            });

        // Recent activity
        $recentActivity = $query->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('modules.payments.reports', compact(
            'stats',
            'revenueChart',
            'paymentMethodsStats',
            'topClients',
            'topMotorcycles',
            'recentActivity'
        ));
    }

    /**
     * Mostra o formulário para registrar pagamento de parcela
     */
    public function showRegisterPaymentForm(Request $request)
    {
        // Buscar vendas ativas com parcelas pendentes
        $payments = Payment::with(['client', 'motorcycle', 'installments'])
            ->where('status', 'ativa')
            ->whereHas('installments', function($query) {
                $query->where('status', 'pendente');
            })
            ->get();

        $paymentMethods = [
            'dinheiro' => 'Dinheiro',
            'cartao_credito' => 'Cartão de Crédito',
            'cartao_debito' => 'Cartão de Débito',
            'pix' => 'PIX',
            'transferencia' => 'Transferência'
        ];

        return view('modules.payments.register-payment', compact('payments', 'paymentMethods'));
    }

    /**
     * Registra um pagamento de parcela
     */
    public function registerPayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'installment_id' => 'required|exists:payment_installments,id',
            'amount_paid' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:dinheiro,cartao_credito,cartao_debito,pix,transferencia',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // Buscar a parcela
            $installment = PaymentInstallment::findOrFail($request->installment_id);
            
            // Verificar se a parcela já foi paga
            if ($installment->status === 'pago') {
                return back()->withErrors(['installment_id' => 'Esta parcela já foi paga.']);
            }

            // Atualizar a parcela
            $installment->update([
                'status' => 'pago',
                'paid_at' => $request->payment_date,
                'notes' => $request->notes
            ]);

            // Atualizar o pagamento principal se todas as parcelas foram pagas
            $payment = $installment->payment;
            $pendingInstallments = $payment->installments()->where('status', 'pendente')->count();
            
            if ($pendingInstallments === 0) {
                $payment->update([
                    'status' => 'concluida',
                    'paid_at' => now()
                ]);
            }

            DB::commit();

            return redirect()->route('payments.index')
                ->with('success', 'Pagamento registrado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erro ao registrar pagamento: ' . $e->getMessage()]);
        }
    }

    /**
     * Busca parcelas pendentes de uma venda específica
     */
    public function getPendingInstallments(Request $request)
    {
        $paymentId = $request->payment_id;
        
        $installments = PaymentInstallment::where('payment_id', $paymentId)
            ->where('status', 'pendente')
            ->orderBy('installment_number')
            ->get();

        // Log para debug
        \Log::info('Parcelas pendentes encontradas:', [
            'payment_id' => $paymentId,
            'count' => $installments->count(),
            'raw_data' => $installments->toArray()
        ]);

        // Incluir os accessors no JSON
        $installmentsWithAccessors = $installments->map(function($installment) {
            $data = [
                'id' => $installment->id,
                'payment_id' => $installment->payment_id,
                'installment_number' => $installment->installment_number,
                'amount' => $installment->amount,
                'due_date' => $installment->due_date,
                'status' => $installment->status,
                'paid_at' => $installment->paid_at,
                'notes' => $installment->notes,
                'formatted_amount' => $installment->formatted_amount,
                'formatted_due_date' => $installment->formatted_due_date,
                'formatted_paid_at' => $installment->formatted_paid_at,
                'status_color' => $installment->status_color,
                'is_overdue' => $installment->is_overdue,
                'days_overdue' => $installment->days_overdue
            ];
            
            // Log para debug de cada parcela
            \Log::info('Parcela processada:', [
                'id' => $installment->id,
                'formatted_amount' => $data['formatted_amount'],
                'formatted_due_date' => $data['formatted_due_date']
            ]);
            
            return $data;
        });

        return response()->json($installmentsWithAccessors);
    }
} 