@props([
    'searchPlaceholder' => 'بحث...',
    'items',
    'columns' => [],
    'canCreate' => null,
    'createRoute' => null,
    'createLabel' => 'إضافة جديد',
    'createIcon' => 'fas fa-plus',
    'editPermission' => null,
    'deletePermission' => null,
    'editRoutePrefix' => null,
    'iconEmpty' => 'fas fa-database',
    'emptyText' => 'لا توجد بيانات',
    'selected' => [],
    'selectAll' => false,
    'section' => '',
    'actions' => true,
])

<div>
    <div class="card">
        <div class="m-3 row g-3 align-items-center">
            <div class="col-12 col-md-4">
                <input type="text" class="form-control" placeholder="{{ $searchPlaceholder }}" wire:model.live.500ms="search">
            </div>

            <div class="col-12 col-md-8 text-md-end text-left">
                @if(count($selected ?? []) > 0)
                    @can($deletePermission)
                        <button wire:click="confirmDeleteSelected" class="btn btn-danger">
                            <i class="fas fa-trash"></i> حذف العناصر المحددة ({{ count($selected ?? []) }})
                        </button>
                    @endcan
                @else
                    @can($canCreate)
                        <a href="{{ route($createRoute) }}" class="btn btn-primary mb-2 mb-md-0">
                            <i class="{{ $createIcon }}"></i> {{ $createLabel }}
                        </a>
                    @endcan
                @endif
            </div>
        </div>

        <div class="card-header pb-0">
            <h4 class="card-title">قائمة {{ $section }}</h4>
            @if(count($selected ?? []) > 0)
                <div class="text-muted mt-1">تم تحديد {{ count($selected ?? []) }} عنصر</div>
            @endif
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-md-nowrap align-middle">
                    <thead>
                        <tr>
                            <th><input type="checkbox" wire:model.live="selectAll"></th>
                            <th>#</th>
                            @foreach($columns as $col)
                                <th>{{ $col['label'] }}</th>
                            @endforeach
                            <th width="200">الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($items as $item)
                            <tr class="@if(in_array($item->id, $selected ?? [])) table-active @endif">
                                <td>
                                    <input type="checkbox" wire:model.live="selected" value="{{ $item->id }}" class="form-check-input">
                                </td>
                                <td>{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>

                                @foreach($columns as $col)
                                    <td>
                                        @php
                                            $replaceMap = [];
                                            foreach((array)$item->getAttributes() as $key => $value) {
                                                $replaceMap['{'.$key.'}'] = $value;
                                            }

                                            foreach($item->getRelations() as $relationName => $relationValue) {
                                                if(is_object($relationValue)) {
                                                    foreach((array)$relationValue->getAttributes() as $key => $value) {
                                                        $replaceMap['{'.$relationName.'.'.$key.'}'] = $value;
                                                    }
                                                }
                                            }

                                            $fieldValue = isset($col['raw']) && $col['raw'] === true
                                                ? str_replace(array_keys($replaceMap), array_values($replaceMap), $col['field'])
                                                : data_get($item, $col['field']);
                                        @endphp

                                        @if(isset($col['raw']) && $col['raw'] === true)
                                            {!! $fieldValue !!}
                                        @else
                                            {{ $fieldValue ?? '-' }}
                                        @endif
                                    </td>
                                @endforeach

                                <td>
                                    @php
                                        // إنشاء خريطة استبدال عامة لكل الخصائص والعلاقات
                                        $replaceMap = [];
                                        foreach((array)$item->getAttributes() as $key => $value) {
                                            $replaceMap['{'.$key.'}'] = $value;
                                        }
                                        foreach($item->getRelations() as $relationName => $relationValue) {
                                            if(is_object($relationValue)) {
                                                foreach((array)$relationValue->getAttributes() as $key => $value) {
                                                    $replaceMap['{'.$relationName.'.'.$key.'}'] = $value;
                                                }
                                            }
                                        }
                                    @endphp

                                    @if($actions === true)
                                        @can($editPermission)
                                            <a href="{{ route($editRoutePrefix . '.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can($deletePermission)
                                            <button wire:click="confirmDelete({{ $item->id }})" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan
                                    @elseif(is_array($actions))
                                        @foreach($actions as $action)
                                            @can($action['permission'] ?? null)
                                                {!! str_replace(array_keys($replaceMap), array_values($replaceMap), $action['button']) !!}
                                            @endcan
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($columns) + 3 }}" class="text-center py-4">
                                    <i class="{{ $iconEmpty }} fa-2x text-muted mb-2"></i>
                                    <br>{{ $emptyText }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
