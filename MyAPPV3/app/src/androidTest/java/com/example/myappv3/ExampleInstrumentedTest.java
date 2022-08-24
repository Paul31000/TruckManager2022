package com.example.myappv3;

import android.content.Context;
import android.location.Location;


import org.junit.Test;
import org.junit.runner.RunWith;

import static org.junit.Assert.*;

import androidx.test.ext.junit.runners.AndroidJUnit4;
import androidx.test.platform.app.InstrumentationRegistry;


/**
 * Instrumented test, which will execute on an Android device.
 *
 * @see <a href="http://d.android.com/tools/testing">Testing documentation</a>
 */
@RunWith(AndroidJUnit4.class)
public class ExampleInstrumentedTest {
    @Test
    public void useAppContext() {
        // Context of the app under test.
        Context appContext = InstrumentationRegistry.getInstrumentation().getTargetContext();
        assertEquals("com.example.lacamioneurv2", appContext.getPackageName());
    }
    
    @Test
    public void testLocation(){

        Location location = new Location("");

        assertEquals("Location[ 0.000000,0.000000 hAcc=??? t=?!? et=?!? vAcc=??? sAcc=??? bAcc=???]",location.toString());
    }
    @Test
    public void testLocationAvecDesCoord(){

        Location location = new Location("");

        location.setLatitude(5.110000);
        location.setLongitude(2.110000);

        assertEquals("Location[ 5.110000,2.110000 hAcc=??? t=?!? et=?!? vAcc=??? sAcc=??? bAcc=???]",location.toString());
    }

}