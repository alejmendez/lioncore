<vs-col class="px-2 mt-4" vs-w="6">
              <ValidationProvider class="w-full" name="{{ $nameModel }}.{{ $field['name'] }}" rules="{{ $field['validations'] }}" v-slot="{ errors, invalid, validated }">
                <label class="vs-input--label"><?php echo e('{{'); ?> $t('{{ $nameModel }}.{{ $field['name'] }}') <?php echo e('}}'); ?></label>
                <v-select
                  label="label"
                  v-model="data.{{ $field['name'] }}"
                  :clearable="false"
                  :options="{{ $field['name'] }}Options"
                  :danger="invalid && validated"
                />
                <span class="text-danger text-sm">@{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
