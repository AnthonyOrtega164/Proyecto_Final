package com.adom.miadopcion.adaptador;

import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.adom.miadopcion.R;
import com.adom.miadopcion.modelos.Publicacion;
import com.squareup.picasso.Picasso;

import java.io.InputStream;
import java.util.ArrayList;
import java.util.List;

public class ListaAdaptadorPublicaciones extends RecyclerView.Adapter<ListaAdaptadorPublicaciones.ViewHolder>{
    private List<Publicacion> mPublicacion;
    Context mContext;

    public ListaAdaptadorPublicaciones(List<Publicacion> data, Context context){
        super();
        this.mPublicacion=data;
        this.mContext=context;
    }

    public ListaAdaptadorPublicaciones(Context context){
        super();
        this.mPublicacion=new ArrayList<Publicacion>();
        this.mContext=context;
    }


    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_lista,parent,false);

        mContext = parent.getContext();
        return new ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(ViewHolder holder, final int position) {
        final Publicacion card = mPublicacion.get(position);

        holder.foto.setImageResource(R.drawable.mascota);
        holder.titulo.setText(card.titulo);
        holder.categoria.setText(card.categoria);
        holder.correop.setText(card.correo_persona);
        holder.telefonop.setText(card.telefono_persona);
        holder.descripcion.setText(card.descripcion);

    }

    @Override
    public int getItemCount() {
        return mPublicacion.size();
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

    class ViewHolder extends RecyclerView.ViewHolder{

        public ImageView foto;
        public TextView titulo;
        public TextView categoria;
        public TextView correop;
        public TextView telefonop;
        public TextView descripcion;

        public ViewHolder(View itemView) {
            super(itemView);
            foto = itemView.findViewById(R.id.foto);
            titulo = itemView.findViewById(R.id.titulo);
            categoria = itemView.findViewById(R.id.categoria);
            correop = itemView.findViewById(R.id.correop);
            telefonop = itemView.findViewById(R.id.telefonop);
            descripcion = itemView.findViewById(R.id.descripcion);
        }
    }
}
