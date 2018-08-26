package com.adom.miadopcion.adaptador;

import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import com.adom.miadopcion.R;
import com.adom.miadopcion.modelos.Publicacion;

import java.io.InputStream;
import java.util.ArrayList;
import java.util.List;

public class ListaAdaptadorPublicaciones extends ArrayAdapter<Publicacion>{
    private List<Publicacion> dataSet;
    Context mContext;

    public ListaAdaptadorPublicaciones(List<Publicacion> data, Context context){
        super(context, R.layout.item_lista,data);
        this.dataSet=data;
        this.mContext=context;
    }

    public ListaAdaptadorPublicaciones(Context context){
        super(context,R.layout.lista_vacia,new ArrayList<Publicacion>());
        this.dataSet=new ArrayList<Publicacion>();
        this.mContext=context;
    }

    @Override
    public View getView(int position,View convertView,ViewGroup parent) {
        LayoutInflater inflater=LayoutInflater.from(mContext);

        View item=null;
        if(dataSet.isEmpty()){
            item=inflater.inflate(R.layout.lista_vacia,null);
        }else{
            item=inflater.inflate(R.layout.item_lista,null);
        }
        new DownloadImageTask((ImageView) item.findViewById(R.id.imgFilm)).execute(dataSet.get(position).ruta_imagen);

        TextView titulo =(TextView)item.findViewById(R.id.titulo);
        TextView descripcion =(TextView)item.findViewById(R.id.descripcion);
        TextView created_at =(TextView)item.findViewById(R.id.fecha);
        Publicacion publicacion =dataSet.get(position);
        titulo.setText(publicacion.titulo);
        descripcion.setText(publicacion.descripcion);
        created_at.setText(publicacion.created_at);
        return item;
    }
    public class DownloadImageTask extends AsyncTask<String, Void, Bitmap> {
        ImageView bmImage;
        public DownloadImageTask(ImageView bmImage){
            this.bmImage=bmImage;
        }
        protected Bitmap doInBackground(String... urls){
            String urldisplay=urls[0];
            Bitmap mIcon11=null;
            try {
                InputStream in=new java.net.URL(urldisplay).openStream();
                mIcon11= BitmapFactory.decodeStream(in);
            }catch (Exception e){
                Log.e("Error",e.getMessage());
                e.printStackTrace();
            }
            return mIcon11;
        }
        protected void onPostExecute(Bitmap result){
            bmImage.setImageBitmap(result);
        }
    }
}
