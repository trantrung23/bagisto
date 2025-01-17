{{-- <div class="flex justify-center items-center w-full py-3 px-16 border border-t-0 border-b border-l-0 border-r-0">
    <x-shop::dropdown>
        <x-slot:toggle>
            <div
                class="flex gap-2.5 cursor-pointer" role="button"
                tabindex="0"
            >
                <span>
                    {{ core()->getCurrentCurrency()->symbol . ' ' . core()->getCurrentCurrencyCode() }}
                </span>

                <span
                    class="text-2xl icon-arrow-down"
                    role="presentation"
                ></span>
            </div>
        </x-slot:toggle>

        <x-slot:content class="!p-0">
            <v-currency-switcher></v-currency-switcher>
        </x-slot:content>
    </x-shop::dropdown>

    <p class="text-xs font-medium">
        Get UPTO 40% OFF on your 1st order <a href="{{ route('shop.home.index') }}" class="underline">SHOP NOW</a>
    </p>

    <x-shop::dropdown position="bottom-right">
        <x-slot:toggle>
            <div
                class="flex items-center gap-2.5 cursor-pointer"
                role="button"
                tabindex="0"
            >
                <img 
                    src="{{ ! empty(core()->getCurrentLocale()->logo_url) 
                            ? core()->getCurrentLocale()->logo_url 
                            : bagisto_asset('images/default-language.svg') 
                        }}"
                    class="h-full"
                    alt="Default locale"
                    width="24"
                    height="16"
                />
                
                <span>
                    {{ core()->getCurrentChannel()->locales()->orderBy('name')->where('code', app()->getLocale())->value('name') }}
                </span>

                <span
                    class="icon-arrow-down text-2xl"
                    role="presentation"
                ></span>
            </div>
        </x-slot:toggle>
    
        <x-slot:content class="!p-0">
            <v-locale-switcher></v-locale-switcher>
        </x-slot:content>
    </x-shop::dropdown>
</div> --}}

<div class="flex justify-center items-center w-full py-3 px-16 border border-t-0 border-b-[1px] border-l-0 border-r-0">
    <p class="text-xs font-medium">
        @lang('shop::app.components.layouts.header.slogan')
    </p>
</div>

@pushOnce('scripts')
    <script type="text/x-template" id="v-currency-switcher-template">
        <div class="grid gap-1 mt-2.5 pb-2.5">
            <span
                class="px-5 py-2 text-base cursor-pointer hover:bg-gray-100"
                v-for="currency in currencies"
                :class="{'bg-gray-100': currency.code == '{{ core()->getCurrentCurrencyCode() }}'}"
                @click="change(currency)"
            >
                @{{ currency.symbol + ' ' + currency.code }}
            </span>
        </div>
    </script>

    <script type="text/x-template" id="v-locale-switcher-template">
        <div class="grid gap-1 mt-2.5 pb-2.5">
            <span
                class="flex items-center gap-2.5 px-5 py-2 text-base cursor-pointer hover:bg-gray-100"
                v-for="locale in locales"
                :class="{'bg-gray-100': locale.code == '{{ app()->getLocale() }}'}"
                @click="change(locale)"                  
            >
                <img
                    :src="locale.logo_url || '{{ bagisto_asset('images/default-language.svg') }}'"
                    width="24"
                    height="16"
                />

                @{{ locale.name }}
            </span>
        </div>
    </script>

    <script type="module">
        app.component('v-currency-switcher', {
            template: '#v-currency-switcher-template',

            data() {
                return {
                    currencies: @json(core()->getCurrentChannel()->currencies),
                };
            },

            methods: {
                change(currency) {
                    let url = new URL(window.location.href);

                    url.searchParams.set('currency', currency.code);

                    window.location.href = url.href;
                }
            }
        });

        app.component('v-locale-switcher', {
            template: '#v-locale-switcher-template',

            data() {
                return {
                    locales: @json(core()->getCurrentChannel()->locales()->orderBy('name')->get()),
                };
            },

            methods: {
                change(locale) {
                    let url = new URL(window.location.href);

                    url.searchParams.set('locale', locale.code);

                    window.location.href = url.href;
                }
            }
        });
    </script>
@endPushOnce
