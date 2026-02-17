document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. CONFIGURACIÓN DEL MODAL (CREAR / EDITAR) ---
    const modalVehiculo = document.getElementById('modalNuevoVehiculo');
    const formVehiculo = document.getElementById('formVehiculo');

    if (modalVehiculo) {
        modalVehiculo.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Botón que abrió el modal
            const autoId = button.getAttribute('data-id');

            // Selectores de la interfaz del modal
            const modalTitle = document.getElementById('modalTitle');
            const methodField = document.getElementById('methodField');
            const btnText = document.getElementById('btnSubmitText');
            const btnIcon = document.getElementById('btnSubmitIcon');

            if (autoId) {
                // MODO EDICIÓN
                modalTitle.textContent = 'Editar Vehículo';
                btnText.textContent = 'Guardar Cambios';
                btnIcon.className = 'bi bi-check-lg';
                methodField.value = 'PUT';
                formVehiculo.action = `/autos/${autoId}`;

                // Llenado de campos básicos
                const fields = [
                    'id_marca', 'modelo', 'year', 'tipo', 'color', 
                    'transmision', 'combustible', 'kilometraje', 'precio', 'descripcion'
                ];

                fields.forEach(field => {
                    const input = document.getElementById(field);
                    if (input) {
                        input.value = button.getAttribute(`data-${field}`) || '';
                    }
                });

                // Checkboxes / Toggles
                document.getElementById('ocultar_kilometraje').checked = button.getAttribute('data-ocultar') === '1';
                document.getElementById('consignacion').checked = button.getAttribute('data-consignacion') === '1';

            } else {
                // MODO CREAR
                modalTitle.textContent = 'Nuevo Vehículo';
                btnText.textContent = 'Registrar Vehículo';
                btnIcon.className = 'bi bi-plus-lg';
                methodField.value = 'POST';
                formVehiculo.action = "/autos";
                formVehiculo.reset();
            }
        });
    }

    // --- 2. BÚSQUEDA ---
    const searchInput = document.getElementById('searchInput');
    const filterForm = document.getElementById('filterForm');
    if (searchInput && filterForm) {
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterForm.submit();
            }
        });
    }

    // --- 3. ELIMINACIÓN (SWEETALERT) ---
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.classList.contains('form-eliminar')) {
            e.preventDefault();
            const form = e.target;
            Swal.fire({
                title: '¿Estás seguro?',
                text: "El vehículo se eliminará permanentemente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }
    });
});