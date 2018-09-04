package com.adom.miadopcion.controlador.utilidades;

import org.apache.commons.lang3.StringUtils;

import java.text.SimpleDateFormat;
import java.util.Date;

public class Utilidades extends StringUtils{
    /**
     *
     * @param date recibe la fecha en formato date
     * @return la fecha con el formato "yyyy-MM-dd HH:mm:ss" para que sea mas vistoso
     */
    public static String formatoFecha(Date date){
        SimpleDateFormat formato = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        String strFecha = "";
        try{
            strFecha = formato.format(date);
            return strFecha;
        }catch (Exception ex){
            ex.printStackTrace();
            return "";
        }
    }

}
