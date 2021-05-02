<vs-col class="px-2" vs-w="6">
              <ValidationProvider class="w-full" name="{{ $nameModel }}.{{ $field['name'] }}" rules="{{ $field['validations'] }}" v-slot="{ errors, invalid, validated }">
                <vs-{{ $field['htmlType'] }}
                  class="w-full mt-4"
                  v-model="data.{{ $field['name'] }}"
                  :danger="invalid && validated"
                  :label="$t('{{ $nameModel }}.{{ $field['name'] }}')"
                />
                <span class="text-danger text-sm">@{{ errors[0] }}</span>
              </ValidationProvider>
            </vs-col>
