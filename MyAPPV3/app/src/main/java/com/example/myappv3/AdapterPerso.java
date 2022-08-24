package com.example.myappv3;

import android.app.Activity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import java.util.List;

public class AdapterPerso extends ArrayAdapter<String> {
    private final Activity context;
    private final List<String> web;
    public AdapterPerso(Activity context,
                        List<String> web) {
        super(context, R.layout.listitemlayout, web);
        this.context = context;
        this.web = web;
    }
    @Override
    public View getView(int position, View view, ViewGroup parent) {
        LayoutInflater inflater = context.getLayoutInflater();
        View rowView= inflater.inflate(R.layout.listitemlayout, null, true);
        TextView txtTitle = (TextView) rowView.findViewById(R.id.Immatricule);
        txtTitle.setText(web.get(position));
        return rowView;
    }
}
