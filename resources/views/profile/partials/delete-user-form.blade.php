<section>
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 px-8 py-3 rounded-lg font-semibold"
    >
        {{ __('Delete My Account') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Are you absolutely sure?</h2>
            <p class="text-gray-600 mb-8">
                This action cannot be undone. All your data will be permanently deleted.
            </p>

            <form method="post" action="{{ route('user.profile.destroy') }}" class="space-y-6">
                @csrf
                @method('delete')

                <div>
                    <x-input-label for="password" :value="__('Enter your password to confirm')" class="text-darkBlue font-semibold" />
                    <x-text-input id="password" name="password" type="password"
                                  class="mt-2 block w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                                  placeholder="Password" />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end gap-4">
                    <x-secondary-button x-on:click="$dispatch('close')" class="px-6 py-3">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <x-danger-button class="px-8 py-3 rounded-lg font-semibold">
                        {{ __('Yes, Delete My Account') }}
                    </x-danger-button>
                </div>
            </form>
        </div>
    </x-modal>
</section>
