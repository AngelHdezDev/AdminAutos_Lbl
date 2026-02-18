// marcas.js — Vista de Gestión de Marcas

document.addEventListener('DOMContentLoaded', function () {

    // ── Notificaciones Laravel → SweetAlert2 ──────────────────────────
    const laravelData = document.getElementById('laravel-data');

    if (laravelData) {
        const hasErrors  = laravelData.dataset.hasErrors === 'true';
        const success    = laravelData.dataset.success;
        const errorMsg   = laravelData.dataset.errorMsg;

        if (success) {
            Swal.fire({
                icon: 'success',
                title: '¡Marca Registrada!',
                text: success,
                background: '#ffffff',
                color: '#1a1a18',
                confirmButtonColor: '#2d2d2a',
                timer: 2500,
                timerProgressBar: true,
                showConfirmButton: false
            });
        }

        if (hasErrors) {
            // Reabrir modal si hubo error de validación
            const modal = new bootstrap.Modal(document.getElementById('modalNuevaMarca'));
            modal.show();

            if (errorMsg) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Revisa el formulario',
                    text: errorMsg,
                    background: '#ffffff',
                    color: '#1a1a18',
                    confirmButtonColor: '#2d2d2a'
                });
            }
        }
    }

    // ── Confirmación antes de eliminar ───────────────────────────────
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: '¿Eliminar esta marca?',
                text: 'También se eliminarán sus asociaciones con vehículos.',
                icon: 'warning',
                showCancelButton: true,
                background: '#ffffff',
                color: '#1a1a18',
                confirmButtonColor: '#c0392b',
                cancelButtonColor:  '#9d9d96',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // ── Upload de imagen con drag & drop ──────────────────────────────
    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('imagen');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const previewName = document.getElementById('previewName');
    const previewSize = document.getElementById('previewSize');
    const uploadInitialState = document.getElementById('uploadInitialState');
    const uploadPreviewState = document.getElementById('uploadPreviewState');
    const uploadPreviewImage = document.getElementById('uploadPreviewImage');
    const btnRemoveImage = document.getElementById('btnRemoveImage');

    if (uploadZone && fileInput) {
        // Prevenir comportamiento por defecto del navegador
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Resaltar zona al arrastrar
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadZone.addEventListener(eventName, () => {
                uploadZone.classList.add('dragging');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, () => {
                uploadZone.classList.remove('dragging');
            }, false);
        });

        // Manejar drop
        uploadZone.addEventListener('drop', e => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect(files[0]);
            }
        }, false);

        // Manejar selección normal
        fileInput.addEventListener('change', e => {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });

        // Botón para remover imagen
        btnRemoveImage?.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            removeImage();
        });

        function removeImage() {
            fileInput.value = '';
            uploadInitialState.style.display = 'block';
            uploadPreviewState.style.display = 'none';
            previewContainer.classList.remove('active');
            uploadZone.style.borderColor = '';
            uploadZone.style.background = '';
        }

        function handleFileSelect(file) {
            // Validar tamaño (2MB)
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Archivo muy grande',
                    text: 'La imagen no debe superar los 2MB',
                    background: '#ffffff',
                    color: '#1a1a18',
                    confirmButtonColor: '#2d2d2a'
                });
                removeImage();
                return;
            }

            // Validar tipo
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Formato no válido',
                    text: 'Solo se permiten archivos JPG y PNG',
                    background: '#ffffff',
                    color: '#1a1a18',
                    confirmButtonColor: '#2d2d2a'
                });
                removeImage();
                return;
            }

            // Mostrar preview
            const reader = new FileReader();
            reader.onload = function(e) {
                // Mostrar imagen grande en la zona de upload
                uploadPreviewImage.src = e.target.result;
                uploadInitialState.style.display = 'none';
                uploadPreviewState.style.display = 'block';
                uploadZone.style.borderColor = 'var(--gold)';
                uploadZone.style.background = 'var(--white)';

                // Mostrar info del archivo
                previewImage.src = e.target.result;
                previewName.textContent = file.name;
                previewSize.textContent = formatBytes(file.size);
                previewContainer.classList.add('active');
            };
            reader.readAsDataURL(file);
        }

        function formatBytes(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }
    }

    // ── Validación del formulario ─────────────────────────────────────
    document.getElementById('formNuevaMarca')?.addEventListener('submit', function (e) {
        const nombre = document.getElementById('nombre');
        const imagen = document.getElementById('imagen');

        // Validar nombre
        if (!nombre.value || nombre.value.trim() === '') {
            e.preventDefault();
            nombre.classList.add('is-invalid');
            nombre.focus();
            Swal.fire({
                icon: 'warning',
                title: 'Campo requerido',
                text: 'Por favor ingresa el nombre de la marca',
                background: '#ffffff',
                color: '#1a1a18',
                confirmButtonColor: '#2d2d2a'
            });
            return;
        }

        // Validar imagen
        if (!imagen.files || imagen.files.length === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Imagen requerida',
                text: 'Por favor selecciona el logo de la marca',
                background: '#ffffff',
                color: '#1a1a18',
                confirmButtonColor: '#2d2d2a'
            });
            return;
        }
    });

    // Limpiar estado inválido al escribir
    document.querySelectorAll('.field-input').forEach(el => {
        el.addEventListener('input', () => el.classList.remove('is-invalid'));
    });

    // ── Buscador en tiempo real ───────────────────────────────────────
    const searchInput = document.getElementById('searchInput');
    const marcasCards = document.querySelectorAll('.marca-card');
    const countEl = document.getElementById('countVisible');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const search = this.value.toLowerCase().trim();
            let visible = 0;

            marcasCards.forEach(card => {
                const nombre = card.dataset.nombre || '';
                const match = nombre.includes(search);
                card.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            if (countEl) countEl.textContent = visible;
        });
    }

    // ── Limpiar modal al cerrar ───────────────────────────────────────
    document.getElementById('modalNuevaMarca')?.addEventListener('hidden.bs.modal', () => {
        const form = document.getElementById('formNuevaMarca');
        if (form) form.reset();
        
        // Resetear visualización de imagen
        if (uploadInitialState && uploadPreviewState) {
            uploadInitialState.style.display = 'block';
            uploadPreviewState.style.display = 'none';
        }
        if (uploadZone) {
            uploadZone.style.borderColor = '';
            uploadZone.style.background = '';
        }
        
        previewContainer?.classList.remove('active');
        
        document.querySelectorAll('.field-input.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    });

});