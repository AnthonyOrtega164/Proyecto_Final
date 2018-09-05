package com.adom.miadopcion;

import android.Manifest;
import android.app.Dialog;
import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.provider.MediaStore;
import android.support.annotation.NonNull;
import android.support.design.widget.BottomNavigationView;
import android.support.v4.content.FileProvider;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.TextView;
import android.widget.Toast;

import com.adom.miadopcion.Imagenes.PhotoUtils;
import com.adom.miadopcion.adaptador.ListaAdaptadorPublicaciones;
import com.adom.miadopcion.controlador.utilidades.Utilidades;
import com.adom.miadopcion.modelos.Publicacion;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.google.firebase.storage.FirebaseStorage;
import com.google.firebase.storage.StorageReference;
import com.google.firebase.storage.UploadTask;
import com.google.gson.Gson;
import com.squareup.picasso.Picasso;

import java.io.File;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

public class CrearPublicacion extends AppCompatActivity {

    //Imagenes
    private AlertDialog _photoDialog;
    private Uri mImageUri;
    private static final int ACTIVITY_SELECT_IMAGE = 1020,
            ACTIVITY_SELECT_FROM_CAMERA = 1040, ACTIVITY_SHARE = 1030;
    private PhotoUtils photoUtils;
    private Boolean fromShare = false;
    private ImageButton photoButton;
    private ImageView photoViewer;
    private BottomNavigationView barra;
    private DatabaseReference mDatabase;
    private StorageReference mStorage;

    EditText mEditTextTitulo,mEditTextDescripcion,mEditTextTelefono;
    RadioGroup mRadio;
    //

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_crear_publicacion);
        mEditTextTitulo = findViewById(R.id.titulo);
        mEditTextDescripcion = findViewById(R.id.descripcion);
        mEditTextTelefono = findViewById(R.id.telefono);
        mRadio = findViewById(R.id.cbCategorias);
        mDatabase= FirebaseDatabase.getInstance().getReference();
        mStorage = FirebaseStorage.getInstance().getReference();
        solicitarDatosFirebase();

        if (Build.VERSION.SDK_INT >=  Build.VERSION_CODES.M) {
            requestPermissions(new String[]{Manifest.permission.CAMERA}, 1);
        }

        Toolbar toolbar = findViewById(R.id.toolbarCrear);
        setSupportActionBar(toolbar);

        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });

        barra = findViewById(R.id.barraImagen);
        barra.setOnNavigationItemSelectedListener(new BottomNavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                switch (item.getItemId()){
                    case R.id.chGaleria:
                        Intent galleryIntent = new Intent(Intent.ACTION_GET_CONTENT);
                        galleryIntent.setType("image/*");
                        startActivityForResult(galleryIntent, ACTIVITY_SELECT_IMAGE);
                        break;
                    case R.id.chCamara:
                        Intent intent = new Intent(
                                "android.media.action.IMAGE_CAPTURE");
                        File photo = null;
                        try {
                            // place where to store camera taken picture
                            photo = PhotoUtils.createTemporaryFile("picture", ".jpg", CrearPublicacion.this);
                            photo.delete();
                        } catch (Exception e) {
                            Log.v(getClass().getSimpleName(),
                                    "Can't create file to take picture!");
                        }
                        mImageUri = FileProvider.getUriForFile(CrearPublicacion.this,BuildConfig.APPLICATION_ID + ".provider", photo);
                        intent.putExtra(MediaStore.EXTRA_OUTPUT, mImageUri);
                        startActivityForResult(intent, ACTIVITY_SELECT_FROM_CAMERA);
                        break;
                }
                return true;
            }
        });

        //imagen
        photoUtils = new PhotoUtils(this);
        Intent intent = getIntent();
        String action = intent.getAction();
        String type = intent.getType();
        if (Intent.ACTION_SEND.equals(action) && type != null) {
            if ("text/plain".equals(type)) {
                fromShare = true;
            } else if (type.startsWith("image/")) {
                fromShare = true;
                mImageUri = (Uri) intent
                        .getParcelableExtra(Intent.EXTRA_STREAM);
                getImage(mImageUri);
            }
        }
        photoButton = findViewById(R.id.photoButton);
        photoViewer = findViewById(R.id.photoViewer);

        photoButton.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v){
                barra.setVisibility(View.VISIBLE);
            }
        });


    }

            //Imagenes
    @Override
    protected void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        if (mImageUri != null)
            outState.putString("Uri", mImageUri.toString());
    }

    private void solicitarDatosFirebase() {
        mDatabase.child("publicacion").addValueEventListener(new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {

                for(final DataSnapshot snapshot : dataSnapshot.getChildren()){

                    mDatabase.child("publicacion").child(snapshot.getKey()).addValueEventListener(new ValueEventListener() {
                        @Override
                        public void onDataChange(DataSnapshot dataSnapshot) {
                            Publicacion user = snapshot.getValue(Publicacion.class);
                            String titulo = user.getTitulo();
                            String descripcion = user.getDescripcion();
                            String categoria = user.getCategoria();
                            String telefono = user.getTelefono_persona();
                        }

                        @Override
                        public void onCancelled(DatabaseError databaseError) {

                        }
                    });

                }

            }
            @Override
            public void onCancelled(DatabaseError databaseError) {

            }
        });
    }

    private void cargarDatosFirebase(String titulo, String descripcion,String categoria, String telefono) {

        Map<String, Object> datosUsuario = new HashMap<>();
        datosUsuario.put("titulo",titulo);
        datosUsuario.put("descripcion",descripcion);
        datosUsuario.put("categoria",categoria);
        datosUsuario.put("telefono_persona",telefono);
        datosUsuario.put("correo_persona",MainActivity.correo_persona);
        datosUsuario.put("created_at",Utilidades.formatoFecha(new Date()));

        mDatabase.child("publicacion").push().setValue(datosUsuario);
        Toast toast1 = Toast.makeText(getApplicationContext(), "Se ha registrado su publicacion", Toast.LENGTH_SHORT);
        toast1.setGravity(Gravity.CENTER_VERTICAL, 0, 0);
        toast1.show();
        Intent intent = new Intent(getApplicationContext(), MainActivity.class);
        intent.removeCategory(Intent.CATEGORY_LAUNCHER);
        startActivity(intent);
    }


    @Override
    protected void onRestoreInstanceState(Bundle savedInstanceState) {
        super.onRestoreInstanceState(savedInstanceState);
        if (savedInstanceState.containsKey("Uri")) {
            mImageUri = Uri.parse(savedInstanceState.getString("Uri"));

        }
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (requestCode == ACTIVITY_SELECT_IMAGE && resultCode == RESULT_OK) {
            mImageUri = data.getData();
            getImage(mImageUri);
            photoViewer.setVisibility(View.VISIBLE);
            barra.setVisibility(View.GONE);
        } else if (requestCode == ACTIVITY_SELECT_FROM_CAMERA
                && resultCode == RESULT_OK) {
            getImage(mImageUri);
            photoViewer.setVisibility(View.VISIBLE);
            barra.setVisibility(View.GONE);
        }
    }

    public void getImage(Uri uri) {
        Bitmap bounds = photoUtils.getImage(uri);
        if (bounds != null) {
            setImageBitmap(bounds);

        }
    }

    private void setImageBitmap(Bitmap bitmap){
        photoViewer.setImageBitmap(bitmap);
    }

    //Tolbar
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_crear_historia, menu);
        return true;
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();

        switch (id){
            case R.id.chPublicar:
                //aqui crean el objeto de la publicación y lo procesan en firebase
                StorageReference filePath=mStorage.child("fotos").child(mImageUri.getLastPathSegment());
                filePath.putFile(mImageUri).addOnSuccessListener(new OnSuccessListener<UploadTask.TaskSnapshot>() {
                    @Override
                    public void onSuccess(UploadTask.TaskSnapshot taskSnapshot) {
                        Toast toast=Toast.makeText(getApplicationContext(),"Se subio correctamente la foto",Toast.LENGTH_SHORT);
                        toast.setGravity(Gravity.CENTER_VERTICAL, 0, 0);
                        toast.show();
                    }
                });
                String titulo = mEditTextTitulo.getText().toString();
                String descripcion = mEditTextDescripcion.getText().toString();
                int radioButtonId = mRadio.getCheckedRadioButtonId();
                View radioButton = mRadio.findViewById(radioButtonId);
                int indice = mRadio.indexOfChild(radioButton);
                RadioButton rb = (RadioButton) mRadio.getChildAt(indice);
                String categoria = rb.getText().toString();
                String telefono = mEditTextTelefono.getText().toString();
                cargarDatosFirebase(titulo, descripcion,categoria,telefono);

                return true;
        }
        return super.onOptionsItemSelected(item);
    }
}
