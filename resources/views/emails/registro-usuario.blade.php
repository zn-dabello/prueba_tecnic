@extends('layouts.mail')
@section('content')
    <main id="register">
        <section class="wrap">
            <div style="text-align: justify;max-width: 600px; background-color:#fff">
                
                Le informamos que se le ha creado una cuenta en el sistema <b>{{ env('APP_NAME') }}</b>, y le damos la bienvenida.
                Para activar su cuenta, le solicitamos conectarse haciendo <b><a href="{{ labelsPlataforma('URL_LOGIN_APLICACION') }}">clic aquí</a></b>, e ingresar con los siguientes datos:
                <br><br><b>Nombre de Usuario:</b><br><span style="text-decoration: none; color: #4f4f4f !important;">{!! limpiarEmailEnvio( trim($user['username']) ) !!}</span>
                <br><br>
                <b>Clave:</b><br>{{ trim($user['clave']) }}
                <br><br>Le informamos que por motivos de seguridad, el sistema le pedirá cambiar su clave al ingresar.
                Usted puede resolver sus dudas contactando a soporte por medio del correo {!! limpiarEmailEnvio( labelsPlataforma('CORREO_APLICACION') ) !!} o al teléfono <b>{{ labelsPlataforma('TELEFONO_APLICACION_VISUAL') }}</b>
                Deseamos que su experiencia con el sistema sea grata.

            </div>
        </section>
    </main>
@endsection