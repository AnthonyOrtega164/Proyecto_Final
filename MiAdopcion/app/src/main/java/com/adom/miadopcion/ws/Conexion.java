package com.adom.miadopcion.ws;

import android.content.Context;
import android.support.annotation.NonNull;

import com.adom.miadopcion.modelos.Persona;
import com.adom.miadopcion.modelos.Publicacion;
import com.android.volley.Request;
import com.android.volley.Response;

import java.util.HashMap;

public class Conexion {

    private  final static String API_URL="http://localhost:80/Proyecto_Final/public/index.php/";

    public static VolleyPeticion<Publicacion> listar
            (@NonNull final Context context,
             @NonNull Response.Listener<Publicacion> responseListener,
             @NonNull Response.ErrorListener errorListener){
        final String url=API_URL+"listar";
        VolleyPeticion request=new VolleyPeticion(context,Request.Method.GET,url,responseListener,errorListener);
        request.setResponseClass(Publicacion.class);
        return request;
    }

    public static VolleyPeticion<Persona> iniciarSesion(
            @NonNull final Context context,
            @NonNull final HashMap mapa,
            @NonNull Response.Listener<Persona> responseListener,
            @NonNull Response.ErrorListener errorListener
    ){
        final String url = API_URL+"inicio_sesion";
        VolleyPeticion request =
                new VolleyPeticion(context,
                Request.Method.POST,
                url,
                mapa,
                HashMap.class,
                String.class,
                responseListener,
                errorListener);
        request.setResponseClass(Persona.class);
        return request;
    }

}
