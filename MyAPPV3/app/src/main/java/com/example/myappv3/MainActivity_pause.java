package com.example.myappv3;

import androidx.appcompat.app.AppCompatActivity;
import androidx.collection.ArraySet;
import androidx.core.app.ActivityCompat;


import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.ResponseDelivery;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class MainActivity_pause extends AppCompatActivity implements LocationListener {

    private LocationManager locationManager;
    private VolleySingleton MySingleton;
    public boolean firstPost=true;
    public String idRequest;
    public HashMap<Integer, String> ListDesCamionsStatus;
    public String urlGlobal="";
    public String idCamion= "";
    public JSONObject object;
    public String faireArrter= "EnAttentePourArret";

    private boolean enPanne = false;
    private boolean enPause = false;
    private boolean arrive = false;


    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main_pause);
    }

    @Override
    public void onResume() {
        super.onResume();
        //Obtention de la référence du service
        locationManager = (LocationManager) this.getSystemService(LOCATION_SERVICE);

        //Si le GPS est disponible, on s'y abonne
        if (locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER)) {
            abonnementGPS();
        }
    }

    @Override
    public void onPause() {
        super.onPause();
        //On appelle la méthode pour se désabonner
        desabonnementGPS();
    }

    /**
     * Méthode permettant de s'abonner à la localisation par GPS.
     */
    public void abonnementGPS() {
        //On s'abonne
        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            // TODO: Consider calling
            //    ActivityCompat#requestPermissions
            // here to request the missing permissions, and then overriding
            //   public void onRequestPermissionsResult(int requestCode, String[] permissions,
            //                                          int[] grantResults)
            // to handle the case where the user grants the permission. See the documentation
            // for ActivityCompat#requestPermissions for more details.
            return;
        }

        locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 10000, 10, this);
    }

    /**
     * Méthode permettant de se désabonner de la localisation par GPS.
     */
    public void desabonnementGPS() {
        //Si le GPS est disponible, on s'y abonne
        locationManager.removeUpdates(this);
    }

    @Override
    public void onLocationChanged(final Location location) {
        final Button Pause = findViewById(R.id.PAUSE);
        final Button Panne = findViewById(R.id.PANNE);
        final Button btarrive = findViewById(R.id.ARRIVE);
        TextView textPanne = findViewById(R.id.Status_Panne);
        TextView textPause = findViewById(R.id.Status_Pause);
        Pause.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                Log.i("","Pause");
                if (enPause == true) {
                    enPause = false;
                    textPause.setVisibility(v.INVISIBLE);
                    Log.i("","Pause Desec");
                    abonnementGPS();
                } else if (enPause == false){
                    enPause = true;
                    Log.i("","Pause Active");
                    textPause.setVisibility(v.VISIBLE);
                    abonnementGPS();
                }
            }
        });

        Panne.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                if (enPanne) {
                    enPanne = false;
                    Log.i("","Panne Desec");
                    textPanne.setVisibility(v.INVISIBLE);
                    abonnementGPS();
                } else {
                    enPanne = true;
                    Log.i("","Panne Active");
                    textPanne.setVisibility(v.VISIBLE);
                    abonnementGPS();
                }
            }
        });

        btarrive.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                if (arrive == false){
                    arrive =true;
                    faireArrter = "ValiderPourArret";
                    abonnementGPS();
                }
            }
        });

        object = genererJsonObject(location);

        if (firstPost == true){
            postJsonRequest(object);
        }else if (firstPost == false){
            RequestQueue queue = Volley.newRequestQueue(this);
            ListDesCamionsStatus = new HashMap<Integer, String>();
            urlGlobal = "http://172.17.51.15:8000/api/camionstatuses/";
            getDataCamionStatus(urlGlobal);
        }

    }

    private void getDataCamionStatus(String urlGlobal) {
        String url = "http://172.17.51.15:8000/api/camionstatuses?page=1";
        Intent intent = getIntent();

        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest
                (Request.Method.GET, url, null, new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            JSONArray responseArray = response.getJSONArray("hydra:member");
                            for (int i = 0; i < responseArray.length(); i++) {
                                JSONObject exploite = responseArray.getJSONObject(i);
                                String camion = exploite.getString("camion");
                                Log.i("DESTINPOM",""+camion);
                                int id = exploite.getInt("id");

                                ListDesCamionsStatus.put(id,camion);
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        if (intent.hasExtra("idCamion")){
                            idCamion = intent.getStringExtra("idCamion");
                        }

                        String elementChercher ="/api/camions/"+idCamion;
                        Log.i("DESTIN",elementChercher.toString());
                        if(ListDesCamionsStatus.containsValue("/api/camions/"+idCamion)){
                            Log.i("DESTINKOL","contenue present");
                            for (int i =0; i < ListDesCamionsStatus.size();i++){
                                for (Object ids : ListDesCamionsStatus.keySet()){
                                    if(elementChercher.equals(ListDesCamionsStatus.get(ids).toString())){
                                        idRequest = String.valueOf(ids);
                                        Log.i("DESTINKOL",String.valueOf(idRequest));
                                    }
                                    i++;
                                }
                            }
                        }
                        MainActivity_pause.this.urlGlobal = urlGlobal +idRequest;
                        putJsonRequest(object,MainActivity_pause.this.urlGlobal);
                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(getApplicationContext(), "Error", Toast.LENGTH_LONG).show();
                        Log.d("Probleme",error.toString());
                    }
                });

        MySingleton.getInstance(this).addToRequestQueue(jsonObjectRequest);
    }

    private void postJsonRequest(JSONObject object) {
        RequestQueue queue = Volley.newRequestQueue(this);

        urlGlobal = "http://172.17.51.15:8000/api/camionstatuses";

        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest
                (Request.Method.POST, urlGlobal, object, new Response.Listener<JSONObject>() {

                    @Override
                    public void onResponse(JSONObject response) {
                    }
                }, new Response.ErrorListener() {

                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.i("", "this it not work "+error.toString());
                    }
                });

// Access the RequestQueue through your singleton class.
        MySingleton.getInstance(this).addToRequestQueue(jsonObjectRequest);
        firstPost = false;
    }

    private JSONObject genererJsonObject(Location location) {

        double latitude = location.getLatitude();
        double longitude = location.getLongitude();

        Intent intent = getIntent();

        String idChauffeur = "";
        if (intent.hasExtra("idChauffeur")){
            idChauffeur = intent.getStringExtra("idChauffeur");
        }
        String idCamion = "";
        if (intent.hasExtra("idCamion")){
            idCamion = intent.getStringExtra("idCamion");
        }

        //First Coord
        JSONObject object = new JSONObject();
        try {

            object.put("latitude", latitude);
            object.put("longitude", longitude);
            object.put("enPanne",enPanne);
            object.put("enPause",enPause);
            object.put("arrive",arrive);
            object.put("camion","api/camions/"+idCamion);
            object.put("chauffeur", "api/chauffeurs/"+idChauffeur);

        } catch (JSONException e) {
            e.printStackTrace();
        }
        Log.i("", object.toString());
        return object;
    }

    private void putJsonRequest(JSONObject object, String urlGlobal) {


        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest
                (Request.Method.PUT, urlGlobal, object, new Response.Listener<JSONObject>() {

                    @Override
                    public void onResponse(JSONObject response) {
                    }
                }, new Response.ErrorListener() {

                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.i("", "this it not work "+error.toString());
                    }
                });
        if(faireArrter == "ValiderPourArret"){
            finish();
        }

// Access the RequestQueue through your singleton class.
        MySingleton.getInstance(this).addToRequestQueue(jsonObjectRequest);
    }

}