package com.adom.miadopcion;

import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.NavigationView;
import android.support.design.widget.Snackbar;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.adom.miadopcion.adaptador.ListaAdaptadorPublicaciones;
import com.adom.miadopcion.controlador.utilidades.Utilidades;
import com.adom.miadopcion.modelos.Publicacion;
import com.facebook.login.LoginManager;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.database.DataSnapshot;
import com.google.firebase.database.DatabaseError;
import com.google.firebase.database.DatabaseReference;
import com.google.firebase.database.FirebaseDatabase;
import com.google.firebase.database.ValueEventListener;
import com.google.gson.Gson;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class MainActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    private DatabaseReference mDatabase;
    private FirebaseUser user;
    public static String nombre_persona=" ";
    public static String correo_persona=" ";
    public static String telefono_persona=" ";

    /*Lista*/
    private RecyclerView mRecyclerView;
    private RecyclerView.LayoutManager mLayoutManager;
    private RecyclerView.Adapter mAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.fab);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Snackbar.make(view, "Contactenos a : spprtadopcion@gmail.com", Snackbar.LENGTH_LONG)
                        .setAction("Action", null).show();
            }
        });

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();

        mDatabase= FirebaseDatabase.getInstance().getReference();

        user= FirebaseAuth.getInstance().getCurrentUser();

        if (user != null) {
            NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
            View hView = navigationView.getHeaderView(0);
            nombre_persona=user.getDisplayName();
            correo_persona=user.getEmail();
            telefono_persona=user.getPhoneNumber();
            TextView nombre =(TextView)hView.findViewById(R.id.texto_nombre);
            TextView correo = (TextView) hView.findViewById(R.id.texto_correo);
            nombre.setText(user.getDisplayName());
            correo.setText(user.getEmail());
            Picasso.get().load(user.getPhotoUrl()).resize(200, 200).into((ImageView) hView.findViewById(R.id.foto_usario));
            navigationView.setNavigationItemSelectedListener(this);
        }else{
            irLogin();
        }

        mRecyclerView = findViewById(R.id.recycler_view);
        mRecyclerView.setHasFixedSize(true);

        mLayoutManager = new LinearLayoutManager(this);
        mRecyclerView.setLayoutManager(mLayoutManager);

        List<Publicacion> lista = new ArrayList<Publicacion>();
        Publicacion prueba = new Publicacion();
        prueba.categoria = "purbea";
        prueba.correo_persona="javier@hotmail.com";
        prueba.descripcion="hermoso Labrador asdsa asdas asd asd asdas dasd asdas d asd asdsad ad as das sd asd asd asd asdas";
        prueba.telefono_persona="2564223";
        prueba.titulo = "Labrador en adopción";
        lista.add(prueba);
        lista.add(prueba);


        mAdapter = new ListaAdaptadorPublicaciones(lista,this);
        mRecyclerView.setAdapter(mAdapter);

    }

    /**
     * Cerrar Sesion:
     * Metodo que cierra sesion de firebase autentificacion y de el login de facebook
     */
    public void cerrarSesion(){
        FirebaseAuth.getInstance().signOut();
        LoginManager.getInstance().logOut();
        irLogin();
    }

    /**
     * irLogin:
     * Metodo que destruye las anteriores tareas y crea una nuevapara ir a la activity Login Activity
     */
    private void irLogin(){
        Intent intent=new Intent(this, LoginActivity.class);
        intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_CLEAR_TASK | Intent.FLAG_ACTIVITY_NEW_TASK);
        startActivity(intent);
    }

    @Override
    protected void onStart() {
        super.onStart();
        mDatabase= FirebaseDatabase.getInstance().getReference();
        ValueEventListener postListener = new ValueEventListener() {
            @Override
            public void onDataChange(DataSnapshot dataSnapshot) {
                Publicacion post = dataSnapshot.getValue(Publicacion.class);
            }

            @Override
            public void onCancelled(DatabaseError databaseError) {
                Toast.makeText(getApplicationContext(),"No se pudo Guardar",Toast.LENGTH_SHORT).show();
            }
        };
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();

        switch (id){
            case R.id.action_settings:
                cerrarSesion();
                return true;
            case R.id.pAction_add:
                Intent intent = new Intent(this, CrearPublicacion.class);
                intent.removeCategory(Intent.CATEGORY_LAUNCHER);
                startActivity(intent);
                return true;
        }
        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {

        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.nav_camera) {
            // Handle the camera action
            Intent intent = new Intent(this, CrearPublicacion.class);
            intent.removeCategory(Intent.CATEGORY_LAUNCHER);
            startActivity(intent);
            return true;
        } else if (id == R.id.nav_gallery) {

        }
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }
}
