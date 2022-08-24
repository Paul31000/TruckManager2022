package com.example.myappv3;

import android.content.Intent;
import android.os.Bundle;

import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;


import java.util.HashMap;


public class MainActivity extends AppCompatActivity {

    private VolleySingleton MySingleton;
    public ListView listeView;
    public HashMap<Integer, String> ListDesPersonne;
    public HashMap<Integer, String> ListDesCamion;
    public int idChauffeur;
    public int idCamion;
    public Intent intent2;

    @Override
    protected void onCreate(final Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        ListDesPersonne = new HashMap<Integer, String>();
        ListDesCamion = new HashMap<Integer, String>();
        intent2 = new Intent(getApplicationContext(), MainActivity_pause.class);


        setContentView(R.layout.activity_main);


        getDataChauffeur("creerleSpinner");

        getDataCamion("creerleSpinner");


        final Button valider = findViewById(R.id.Valider);

        valider.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                Log.d("affichage", "Marche2");
                getDataChauffeur("autre");
                getDataCamion("autre");

                startActivity(intent2);

            }
        });
    }


    private void createSpinerChauffeur(HashMap listDesPersonne ,String raisonDExec) {

        Spinner dynamicSpinnerChauffeur = (Spinner) findViewById(R.id.ListeDesChaffeurs);
        if (raisonDExec=="creerleSpinner"){
            String[] idChauffeur = new String[listDesPersonne.size()];
            String[] items = new String[listDesPersonne.size()];
            int  i = 0;
            for (Object ids : listDesPersonne.keySet()){
                items[i] = ""+ listDesPersonne.get(ids);
                i++;
            }

            ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,
                    android.R.layout.simple_spinner_item, items);

            dynamicSpinnerChauffeur.setAdapter(adapter);
        }
        dynamicSpinnerChauffeur.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
                @Override
                public void onItemSelected(AdapterView<?> parent, View view,
                                           int position, long id) {
                  String contenue =  dynamicSpinnerChauffeur.getItemAtPosition(position).toString();

                 if(listDesPersonne.containsValue(contenue)){
                     for (int i =0; i < listDesPersonne.size();i++){
                         for (Object ids : listDesPersonne.keySet()){
                             if(contenue.equals(listDesPersonne.get(ids).toString())){
                                 idChauffeur = (int) ids;
                                 intent2.putExtra("idChauffeur",String.valueOf(idChauffeur));
                             }
                             i++;
                         }
                     }
                 }
                }

                @Override
                public void onNothingSelected(AdapterView<?> parent) {
                    // TODO Auto-generated method stub
                }
            });
    }

    private void getDataChauffeur(String raisonDExec) {
        String url = "http://172.17.51.15:8000/api/chauffeurs?page=1";

        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest
                (Request.Method.GET, url, null, new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            JSONArray responseArray = response.getJSONArray("hydra:member");
                            for (int i = 0; i < responseArray.length(); i++) {
                                JSONObject exploite = responseArray.getJSONObject(i);
                                String nomPrenom = exploite.getString("nomPrenom");
                                int id = exploite.getInt("id");
                                ListDesPersonne.put(id,nomPrenom);
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        createSpinerChauffeur(ListDesPersonne,raisonDExec);
                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(getApplicationContext(), "Error", Toast.LENGTH_LONG).show();
                        Log.d("Probleme",error.toString());
                    }
                });

        MySingleton.getInstance(this).addToRequestQueue(jsonObjectRequest);
        Log.d("DESTIN3", ""+ListDesPersonne);
    }

    private void createSpinerCamion(HashMap listDesCamion ,String raisonDExec) {

        Spinner dynamicSpinnerCamion = (Spinner) findViewById(R.id.listeDesCamion);
        if (raisonDExec=="creerleSpinner"){
            String[] idChauffeur = new String[listDesCamion.size()];
            String[] items = new String[listDesCamion.size()];
            int  i = 0;
            for (Object ids : listDesCamion.keySet()){
                items[i] = ""+ listDesCamion.get(ids);
                i++;
            }

            ArrayAdapter<String> adapter = new ArrayAdapter<String>(this,
                    android.R.layout.simple_spinner_item, items);

            dynamicSpinnerCamion.setAdapter(adapter);
        }
         dynamicSpinnerCamion.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
                @Override
                public void onItemSelected(AdapterView<?> parent, View view,
                                           int position, long id) {
                    String contenue =  dynamicSpinnerCamion.getItemAtPosition(position).toString();

                    if(listDesCamion.containsValue(contenue)){
                        for (int i =0; i < listDesCamion.size();i++){
                            for (Object ids : listDesCamion.keySet()){
                                if(contenue.equals(listDesCamion.get(ids).toString())){
                                    idCamion = (int) ids;
                                    intent2.putExtra("idCamion",String.valueOf(idCamion));
                                }
                                i++;
                            }
                        }
                    }
                }

                @Override
                public void onNothingSelected(AdapterView<?> parent) {
                    // TODO Auto-generated method stub
                }
            });

    }

    private void getDataCamion(String raisonDExec) {
        String url = "http://172.17.51.15:8000/api/camions?page=1";

        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest
                (Request.Method.GET, url, null, new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            JSONArray responseArray = response.getJSONArray("hydra:member");
                            for (int i = 0; i < responseArray.length(); i++) {
                                JSONObject exploite = responseArray.getJSONObject(i);
                                String imatriculation = exploite.getString("imatriculation");
                                int id = exploite.getInt("id");
                                ListDesCamion.put(id,imatriculation);
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        createSpinerCamion(ListDesCamion,raisonDExec);
                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(getApplicationContext(), "Error", Toast.LENGTH_LONG).show();
                        Log.d("Probleme",error.toString());
                    }
                });

        MySingleton.getInstance(this).addToRequestQueue(jsonObjectRequest);
        Log.d("DESTIN3", ""+ListDesCamion);
    }
}