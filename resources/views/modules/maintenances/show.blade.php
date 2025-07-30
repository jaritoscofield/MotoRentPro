@extends('layouts.dashboard')

@section('title', 'Detalhes da Manutenção - MotoRentPro')
@section('page-title', 'Detalhes da Manutenção')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Manutenção #{{ $maintenance->id }}</h2>
                    <p class="mt-1 text-sm text-gray-600">Detalhes completos da manutenção</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="/manutencao/{{ $maintenance->id }}/edit" class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-edit mr-1.5 text-xs"></i>
                        Editar
                    </a>
                    <a href="/manutencao" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-arrow-left mr-1.5 text-xs"></i>
                        Voltar
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Status Badge -->
            <div class="mb-6">
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $maintenance->status_color }}-100 text-{{ $maintenance->status_color }}-800">
                        <i class="{{ $maintenance->type_icon }} mr-1.5 text-xs"></i>
                        {{ $maintenance->status }}
                    </span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $maintenance->priority_color }}-100 text-{{ $maintenance->priority_color }}-800">
                        Prioridade: {{ $maintenance->priority }}
                    </span>
                    @if($maintenance->is_overdue)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <i class="fas fa-exclamation-triangle mr-1.5 text-xs"></i>
                            Atrasada
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h3 class="text-md font-medium text-gray-900">Informações Básicas</h3>
                        </div>
                        <div class="px-4 py-3">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Tipo</dt>
                                    <dd class="text-sm text-gray-900 flex items-center">
                                        <i class="{{ $maintenance->type_icon }} text-gray-400 mr-2 text-xs"></i>
                                        {{ $maintenance->type }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Data Agendada</dt>
                                    <dd class="text-sm text-gray-900">{{ $maintenance->formatted_scheduled_date }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Data de Conclusão</dt>
                                    <dd class="text-sm text-gray-900">{{ $maintenance->formatted_completed_date }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Próxima Manutenção</dt>
                                    <dd class="text-sm text-gray-900">{{ $maintenance->formatted_next_maintenance_date }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Custo</dt>
                                    <dd class="text-sm text-gray-900">{{ $maintenance->formatted_cost }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Horas de Trabalho</dt>
                                    <dd class="text-sm text-gray-900">{{ $maintenance->labor_hours ?? '-' }} horas</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Quilometragem no Serviço</dt>
                                    <dd class="text-sm text-gray-900">{{ $maintenance->mileage_at_service ? number_format($maintenance->mileage_at_service, 0, ',', '.') . ' km' : '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Técnico Responsável</dt>
                                    <dd class="text-sm text-gray-900">{{ $maintenance->technician ?? '-' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h3 class="text-md font-medium text-gray-900">Descrição</h3>
                        </div>
                        <div class="px-4 py-3">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $maintenance->description }}</p>
                        </div>
                    </div>

                    <!-- Parts Used -->
                    @if($maintenance->parts_used)
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h3 class="text-md font-medium text-gray-900">Peças Utilizadas</h3>
                        </div>
                        <div class="px-4 py-3">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $maintenance->parts_used }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Notes -->
                    @if($maintenance->notes)
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h3 class="text-md font-medium text-gray-900">Observações</h3>
                        </div>
                        <div class="px-4 py-3">
                            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $maintenance->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Motorcycle Information -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h3 class="text-md font-medium text-gray-900">Motocicleta</h3>
                        </div>
                        <div class="px-4 py-3">
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Modelo</dt>
                                    <dd class="text-sm text-gray-900">{{ $maintenance->motorcycle->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Placa</dt>
                                    <dd class="text-sm text-gray-900">{{ $maintenance->motorcycle->license_plate }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Ano</dt>
                                    <dd class="text-sm text-gray-900">{{ $maintenance->motorcycle->year }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Status</dt>
                                    <dd class="text-sm">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $maintenance->motorcycle->status_color }}-100 text-{{ $maintenance->motorcycle->status_color }}-800">
                                            {{ $maintenance->motorcycle->status }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Quilometragem Atual</dt>
                                    <dd class="text-sm text-gray-900">{{ $maintenance->motorcycle->formatted_mileage }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- System Information -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h3 class="text-md font-medium text-gray-900">Informações do Sistema</h3>
                        </div>
                        <div class="px-4 py-3">
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Criado em</dt>
                                    <dd class="text-sm text-gray-900">{{ $maintenance->formatted_created_at }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500">Última atualização</dt>
                                    <dd class="text-sm text-gray-900">{{ $maintenance->updated_at->format('d/m/Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white rounded-lg border border-gray-200">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <h3 class="text-md font-medium text-gray-900">Ações</h3>
                        </div>
                        <div class="px-4 py-3 space-y-3">
                            <a href="/manutencao/{{ $maintenance->id }}/edit" class="w-full inline-flex items-center justify-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <i class="fas fa-edit mr-1.5 text-xs"></i>
                                Editar Manutenção
                            </a>
                            <button onclick="deleteMaintenance({{ $maintenance->id }})" class="w-full inline-flex items-center justify-center px-3 py-1.5 border border-transparent rounded-md text-xs font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <i class="fas fa-trash mr-1.5 text-xs"></i>
                                Excluir Manutenção
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteMaintenance(id) {
    if (confirm('Tem certeza que deseja excluir esta manutenção? Esta ação não pode ser desfeita.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/manutencao/${id}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection 