@if (isset($errors) && count($errors) > 0)
<div class="alert alert-danger auto-dismiss">
    <ul class="list-unstyled mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))
        @foreach ($data as $message)
            <div class="alert alert-success auto-dismiss">
                <i class="fa fa-check"></i>
                {{ $message }}
            </div>
        @endforeach
    @else
        <div class="alert alert-success auto-dismiss">
            <i class="fa fa-check"></i>
            {{ $data }}
        </div>
    @endif
@endif

<style>
    /* Estilos específicos para los tipos de alerta */
    .alert-danger {
        color: #000000;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }
    
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }
    
    .alert-success i.fa-check {
        margin-right: 0.5rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Seleccionar todos los mensajes con la clase auto-dismiss
        const alerts = document.querySelectorAll('.auto-dismiss');
        
        alerts.forEach(alert => {
            // Configurar temporizador para eliminar el mensaje después de 3 segundos
            setTimeout(() => {
                alert.remove();
            }, 3000);
        });
    });
</script>