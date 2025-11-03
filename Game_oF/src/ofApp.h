#pragma once

#include "ofMain.h"
#include "../Player.h"
#include "../Bullet.h"
#include "../Life.h"
#include "../Enemy.h"
#include "../LevelController.h"

#include "ofxOsc.h"

#include "vector"

class ofApp : public ofBaseApp{

	public:
		void setup();
		void update();
		void draw();

		void keyPressed(int key);
		void keyReleased(int key);
		void mouseMoved(int x, int y );
		void mouseDragged(int x, int y, int button);
		void mousePressed(int x, int y, int button);
		void mouseReleased(int x, int y, int button);
		void mouseEntered(int x, int y);
		void mouseExited(int x, int y);
		void windowResized(int w, int h);
		void dragEvent(ofDragInfo dragInfo);
		void gotMessage(ofMessage msg);
	
		int score;
		float max_enemy_amplitude;
		float max_enemy_shoot_interval;

		vector<Bullet> bullets;
		vector<Enemy> enemies;
		vector<Life> bonuses;

		string game_state;
		Player player_1;
		LevelController level_controller;
		
		ofImage player_image;
		ofImage enemy_bullet_image;
		ofImage player_bullet_image;
		ofImage enemy_image;
		ofImage life_image;
		ofImage end_screen;
		ofImage start_screen;

		ofTrueTypeFont score_font;


		void update_bullets(); // mets à jour les balles du pistolet
		void check_bullet_collisions();
		void update_bonuses();
		void draw_lives();
		void draw_score();

		bool testing;

};