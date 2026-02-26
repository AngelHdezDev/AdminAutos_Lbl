// detalle-vehiculo.js

document.addEventListener('DOMContentLoaded', function() {

    // ── Cambiar imagen principal al hacer clic en thumbnail ───────────
    window.changeImage = function(imageUrl, thumbnailElement) {
        const featuredImage = document.getElementById('featuredImage');
        if (featuredImage) {
            featuredImage.src = imageUrl;
        }

        // Remover clase active de todos los thumbnails
        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.classList.remove('active');
        });

        // Agregar clase active al thumbnail seleccionado
        if (thumbnailElement) {
            thumbnailElement.classList.add('active');
        }
    };

    // ── Ver imagen en pantalla completa ───────────────────────────────
    window.viewFullscreen = function() {
        const featuredImage = document.getElementById('featuredImage');
        if (featuredImage) {
            Swal.fire({
                imageUrl: featuredImage.src,
                imageAlt: 'Vista de imagen',
                showCloseButton: true,
                showConfirmButton: false,
                background: '#ffffff',
                padding: '1rem',
                width: 'auto',
                customClass: {
                    popup: 'fullscreen-image-popup',
                    image: 'img-fluid'
                }
            });
        }
    };

    // ── Navegación con teclado en galería ─────────────────────────────
    document.addEventListener('keydown', function(e) {
        const thumbnails = Array.from(document.querySelectorAll('.thumbnail-item'));
        const activeThumbnail = document.querySelector('.thumbnail-item.active');
        
        if (!activeThumbnail || thumbnails.length <= 1) return;

        const currentIndex = thumbnails.indexOf(activeThumbnail);

        if (e.key === 'ArrowLeft' && currentIndex > 0) {
            // Imagen anterior
            thumbnails[currentIndex - 1].click();
        } else if (e.key === 'ArrowRight' && currentIndex < thumbnails.length - 1) {
            // Imagen siguiente
            thumbnails[currentIndex + 1].click();
        }
    });

    // ── Confirmación antes de eliminar vehículo ───────────────────────
    const btnDelete = document.querySelector('.btn-delete');
    if (btnDelete) {
        btnDelete.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: '¿Eliminar este vehículo?',
                text: 'Esta acción no se puede deshacer. Se eliminarán todos los datos y las imágenes asociadas.',
                icon: 'warning',
                showCancelButton: true,
                background: '#ffffff',
                color: '#1a1a18',
                confirmButtonColor: '#c0392b',
                cancelButtonColor: '#9d9d96',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    }

});