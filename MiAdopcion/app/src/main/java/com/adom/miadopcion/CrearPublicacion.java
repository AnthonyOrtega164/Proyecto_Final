package com.adom.miadopcion;

import android.Manifest;
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
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageButton;
import android.widget.ImageView;

import com.adom.miadopcion.Imagenes.PhotoUtils;

import java.io.File;

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

    //

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_crear_publicacion);

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
                return true;
        }
        return super.onOptionsItemSelected(item);
    }
}
