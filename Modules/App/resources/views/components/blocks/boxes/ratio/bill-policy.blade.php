@props([
    'value',

])
    <!-- Customer Portal -->
    <div class="k_settings_box col-12 col-lg-6 k_searchable_setting" id="{{ $value->key }}">

        <!-- Right pane -->
        <div class="k_setting_right_pane">
            <div class="mt12">
                <div class="w-auto k_field_widget k_field_chat k_read_only modify ps-3 fw-bold">
                    <span>{{ $value->label }}</span>
                </div>
                <div class="w-auto k_field_widget k_field_text k_read_only modify ps-3 text-muted">
                    <span>
                        {{ $value->description }}
                    </span>
                </div>
            </div>
            <div class="mt16">
                <div class="w-auto k_field_widget k_field_text k_read_only modify ps-3 text-muted" data-bs-toggle="tooltip" data-bs-placement="right" title="Cette valeur est appliquée par défaut sur tous les nouveaux produits. Ceci peut être modifié dans la fiche du produit.">
                    <!-- What is ordered -->
                    <div>
                        <div class="form-check k_radio_item">
                            <input type="radio" class="form-check-input k_radio_input" wire:model.live="{{ $value->model }}" name="{{ $value->model }}" id="ordered" value="ordered"/>
                            <label class="form-check-label k_form_label" for="ordered">
                                {{ __('Quantité commandées') }}
                            </label>
                        </div>
                    </div>
                    <!-- What is delivered -->
                    <div>
                        <div class="form-check k_radio_item">
                            <input type="radio" class="form-check-input k_radio_input" wire:model.live="{{ $value->model }}" name="{{ $value->model }}" id="delivered" value="delivered"/>
                            <label class="form-check-label k_form_label" for="delivered">
                                {{ __('Quantité reçues') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
