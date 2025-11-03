#pragma once
#include "ofxOsc.h"

class LiveTesting
{
public:

	LiveTesting();

	void setup();
	void update();

	ofxOscSender sender;

	//on peut mettre en place un expéditeur !Nous allons nous en servir pour savoir quelles sont nos valeurs dans notre jeu au fur et à mesure que nous les modifions, nous donnant ainsi la possibilité de les référencer si elles semblent fonctionner et de les sauvegarder dans notre jeu pour une utilisation ultérieure.
	ofxOscReceiver receiver;
	
	//this is the magic! This is how your game gets incoming data
	ofxOscMessage m;
	//this is the osc message it gets.

	//these are the values we will be tweeking during testing
	float max_enemy_amplitude;
	int interval_time;
	float max_enemy_shoot_interval;
	bool triggerBonus;

//	LiveTesting();
//	~LiveTesting();
};