<div>
    <form wire:submit.prevent="{{$method}}">
    <x-component-modal :showModal="$showModal" :action="$action">
        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
          <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
            Edición de usuario
          </h3>
          <div class="mt-2">
            <p class="text-sm text-gray-500">

                    <div class="flex">
                        <x-component-input placeholder="Ingrese su nombre" name="name" label="Nombre"></x-component-input>
                        <x-component-input placeholder="Ingrese su apellido" name="lastname" label="Apellido"></x-component-input>
                    </div>
                    <div>
                        <x-component-input placeholder="Ingrese su correo" name="email" label="Correo"></x-component-input>
                    </div>
                    
                    @if ($action == 'Añadir')
                    <div class="flex">
                        <x-component-input placeholder="Ingrese su contraseña" name="password" label="Contraseña" type="password"></x-component-input>
                        <x-component-input placeholder="Confirme su contraseña" name="password_confirmation" label="Confirme su contraseña" type="password"></x-component-input>
                    </div>
                    @endif
                    <div>
                        <x-component-input-select
                        name="role"
                        label="Rol"
                        :options="['admin' => 'Administrador', 'seller' => 'Vendedor', 'client' => 'Cliente']"
                        >
                        </x-component-input-select>

                    </div>
                    <div>
                        <x-component-input placeholder="Ingrese su imagen" name="profile_photo_path" type="file" label="Imagen"></x-component-input>
                    </div>

            </p>
          </div>
        </div>
    </x-component-modal>
    </form>
</div>
