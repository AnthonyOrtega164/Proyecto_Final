package com.adom.miadopcion.modelos;

public class Publicacion {
    public String id_publicacion;
    public String titulo;
    public String descripcion;
    public String categoria;
    public String created_at;
    public String updated_at;
    public String correo_persona;
    public String telefono_persona;
    public String ruta_imagen;

    public String getRuta_imagen() {
        return ruta_imagen;
    }

    public void setRuta_imagen(String ruta_imagen) {
        this.ruta_imagen = ruta_imagen;
    }

    public String getId_publicacion() {
        return id_publicacion;
    }

    public void setId_publicacion(String id_publicacion) {
        this.id_publicacion = id_publicacion;
    }

    public String getTitulo() {
        return titulo;
    }

    public void setTitulo(String titulo) {
        this.titulo = titulo;
    }

    public String getDescripcion() {
        return descripcion;
    }

    public void setDescripcion(String descripcion) {
        this.descripcion = descripcion;
    }

    public String getCategoria() {
        return categoria;
    }

    public void setCategoria(String categoria) {
        this.categoria = categoria;
    }

    public String getCreated_at() {
        return created_at;
    }

    public void setCreated_at(String created_at) {
        this.created_at = created_at;
    }

    public String getUpdated_at() {
        return updated_at;
    }

    public void setUpdated_at(String updated_at) {
        this.updated_at = updated_at;
    }

    public String getCorreo_persona() {
        return correo_persona;
    }

    public void setCorreo_persona(String correo_persona) {
        this.correo_persona = correo_persona;
    }

    public String getTelefono_persona() {
        return telefono_persona;
    }

    public void setTelefono_persona(String telefono_persona) {
        this.telefono_persona = telefono_persona;
    }

}
