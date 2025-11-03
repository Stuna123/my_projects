#include "Player.h"



void Player::setup(ofImage * _img)
{
	//vie et vitesse du joueur
	lives = 3;
	speed = 5;

	// charge l'image du joueur
	img = _img;
	width = height = img->getWidth();

	//position
	pos.x = ofGetWidth() / 2;
	pos.y = ofGetHeight() - height * 2;
}

void Player::update()
{
	//on met à jour le deplacement du joueur
	calculate_movement();
}

void Player::draw()
{
	//on dessine l'image du joueur avec sa position
	img->draw(pos.x - width / 2, pos.y - height / 2);
}

void Player::calculate_movement()
{
	//On calcul le mouvement ou le deplacement du joueur
	if (is_left_pressed && pos.x > 0 + width / 2) {
		pos.x -= speed;
	}

	if (is_right_pressed && pos.x < ofGetWidth() - width / 2) {
		pos.x += speed;
	}

	if (is_up_pressed && pos.y > 0 + height / 2) {
		pos.y -= speed;
	}

	if (is_down_pressed && pos.y < ofGetHeight() - height / 2) {
		pos.y += speed;
	}
}

bool Player::check_can_shoot()
{
	return false;
}

Player::Player()
{
}

Player::~Player()
{
}

void Player::shoot() {
}