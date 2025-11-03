#include "ofApp.h"
#include "ofVectorMath.h"

//--------------------------------------------------------------
void ofApp::setup(){
	//on initialise notre état du jeu à start
	game_state = "start";

	max_enemy_amplitude = 3.0;
	max_enemy_shoot_interval = 1.5;

	//On recupère les images
	enemy_image.load("ennemi.png");
	player_image.load("joueur.png");
	enemy_bullet_image.load("enemy0_bullet.png");
	player_bullet_image.load("joueur_tire.png");
	life_image.load("life_image.png");

	player_1.setup(&player_image);
	start_screen.load("start_screen.png");
	end_screen.load("end_screen.png");
	score_font.load("Roboto-Thin.ttf", 50);

	score = 0;
}

//--------------------------------------------------------------
void ofApp::update() {
	if (game_state == "start") {

	}
	else if (game_state == "game") {
		player_1.update();
		update_bullets();
		update_bonuses();

		for (unsigned int i = 0; i < enemies.size(); i++) {
			enemies[i].update();
			if (enemies[i].time_to_shoot()) {
				Bullet b;
				b.setup(false, enemies[i].pos, enemies[i].speed, &enemy_bullet_image);
				bullets.push_back(b);
			}
		}

		if (level_controller.should_spawn() == true) {
			Enemy e;
			e.setup(max_enemy_amplitude, max_enemy_shoot_interval, &enemy_image);
			enemies.push_back(e);
		}
	}
}

//--------------------------------------------------------------
void ofApp::draw() {
	//Etat du jeu
	if (game_state == "start") {
		start_screen.draw(0, 0);
	}
	else if (game_state == "game") {
		ofBackground(0, 0, 0);
		player_1.draw();
		draw_lives();


		for (unsigned int i = 0; i < enemies.size(); i++) {
			enemies[i].draw();
		}

		for (unsigned int i = 0; i < bullets.size(); i++) {
			bullets[i].draw();
		}

		for (unsigned int i = 0; i < bonuses.size(); i++) {
			bonuses[i].draw();
		}
		//On affiche le score
		draw_score();
	}
	//Si on perd, on affiche le resultat final
	else if (game_state == "end") {
		end_screen.draw(0, 0);
		draw_score(); 
	}

}


//--------------------------------------------------------------
void ofApp::keyPressed(int key){

	//Les touches appuyées lors du deplacement du joueur
	if (game_state == "game") {
		if (key == OF_KEY_LEFT) {
			player_1.is_left_pressed = true;
		}

		if (key == OF_KEY_RIGHT) {
			player_1.is_right_pressed = true;
		}

		if (key == OF_KEY_UP) {
			player_1.is_up_pressed = true;
		}

		if (key == OF_KEY_DOWN) {
			player_1.is_down_pressed = true;
		}

		//Pour générer uune balle en appuyant sur espace
		if (key == ' ') {
			Bullet b;
			b.setup(true, player_1.pos, player_1.speed, &player_bullet_image);
			bullets.push_back(b);
		}

		if (key == OF_KEY_BACKSPACE) {
			game_state = "game";
			update();
		}
	}
}

//--------------------------------------------------------------
void ofApp::keyReleased(int key) {

	if (game_state == "start") {
		game_state = "game";
		level_controller.setup(ofGetElapsedTimeMillis());
	}
	else if (game_state == "game") {
		if (key == OF_KEY_LEFT) {
			player_1.is_left_pressed = false;
		}

		if (key == OF_KEY_RIGHT) {
			player_1.is_right_pressed = false;
		}

		if (key == OF_KEY_UP) {
			player_1.is_up_pressed = false;
		}

		if (key == OF_KEY_DOWN) {
			player_1.is_down_pressed = false;
		}

		// Controle d'aspect du jeu
		if (key == '1') {
			max_enemy_amplitude -= .5;
		}

		if (key == '2') {
			max_enemy_amplitude += .5;
		}

		if (key == '3') {
			level_controller.interval_time += 50;
		}

		if (key == '4') {
			level_controller.interval_time -= 50;
		}

		if (key == '5') {
			if (max_enemy_shoot_interval > 0) {
				max_enemy_shoot_interval -= .1;
			}
		}

		if (key == '6') {
			max_enemy_shoot_interval += .1;
		}

		if (key == '7') {
			Life l;
			l.setup(&life_image);
			bonuses.push_back(l);
		}

	}
}

//--------------------------------------------------------------
void ofApp::mouseMoved(int x, int y ){

}

//--------------------------------------------------------------
void ofApp::mouseDragged(int x, int y, int button){

}

//--------------------------------------------------------------
void ofApp::mousePressed(int x, int y, int button){

}

//--------------------------------------------------------------
void ofApp::mouseReleased(int x, int y, int button){

}

//--------------------------------------------------------------
void ofApp::mouseEntered(int x, int y){

}

//--------------------------------------------------------------
void ofApp::mouseExited(int x, int y){

}

//--------------------------------------------------------------
void ofApp::windowResized(int w, int h){

}

//--------------------------------------------------------------
void ofApp::gotMessage(ofMessage msg){

}

void ofApp::update_bullets()
{
	for (unsigned int i = 0; i < bullets.size(); i++) {
		bullets[i].update();
	//	if (bullets[i].pos.y - bullets[i].width / 2 < 0
	//	|| bullets[i].pos.y + bullets[i].width / 2 > ofGetHeight()) {
	//		bullets.erase(bullets.begin() + i);
	//	}
	}

	check_bullet_collisions();
}

void ofApp::check_bullet_collisions() {
	for (unsigned int i = 0; i < bullets.size(); i++) {
		if (bullets[i].from_player) {
			for (int e = enemies.size() - 1; e >= 0; e--) {
				if (ofDist(bullets[i].pos.x, bullets[i].pos.y, enemies[e].pos.x, enemies[e].pos.y) < (enemies[e].width + bullets[i].width) / 2) {
					enemies.erase(enemies.begin() + e);
					bullets.erase(bullets.begin() + i);
					score += 10;
				}
			}
		}
		else {
			if (ofDist(bullets[i].pos.x, bullets[i].pos.y, player_1.pos.x, player_1.pos.y) < (bullets[i].width + player_1.width) / 2) {
				bullets.erase(bullets.begin() + i);
				player_1.lives--;

				if (player_1.lives <= 0) {
					game_state = "end";
				}
			}
		}
	}

}

//--------------------------------------------------------------
void ofApp::update_bonuses() {
	for (int i = bonuses.size() - 1; i > 0; i--) {
		bonuses[i].update();
		if (ofDist(player_1.pos.x, player_1.pos.y, bonuses[i].pos.x, bonuses[i].pos.y) < (player_1.width + bonuses[i].width) / 2) {
			player_1.lives++;
			bonuses.erase(bonuses.begin() + i);
		}

		if (bonuses[i].pos.y + bonuses[i].width / 2 > ofGetHeight()) {
			bonuses.erase(bonuses.begin() + i);
		}
	}
}

//--------------------------------------------------------------
void ofApp::draw_lives() {
	for (int i = 0; i < player_1.lives; i++) {
		player_image.draw(ofGetWidth() - (i * player_image.getWidth()) - 100, 30);
	}

}

//--------------------------------------------------------------
void ofApp::draw_score() {
	if (game_state == "game") {
		score_font.drawString(ofToString(score), 30, 72);
	}
	else if (game_state == "end") {
		float w = score_font.stringWidth(ofToString(score));
		score_font.drawString(ofToString(score), ofGetWidth() / 2 - w / 2, ofGetHeight() / 2 + 100);
	}
}

//--------------------------------------------------------------
void ofApp::dragEvent(ofDragInfo dragInfo){ 

}
