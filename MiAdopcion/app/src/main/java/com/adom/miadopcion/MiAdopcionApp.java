package com.adom.miadopcion;

import android.app.Application;

import com.facebook.appevents.AppEventsLogger;

public class MiAdopcionApp extends Application {

    @Override
    public void onCreate() {
        super.onCreate();

        AppEventsLogger.activateApp(this);
    }
}
