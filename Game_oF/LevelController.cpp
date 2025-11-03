#include "LevelController.h"



bool LevelController::should_spawn()
{
	if (ofGetElapsedTimeMillis() - start_time > interval_time) {
		start_time = ofGetElapsedTimeMillis();
		return true;
	}
	return false;
}

void LevelController::setup(float s) {
	start_time = s;
	interval_time = 500;
}

LevelController::LevelController()
{
}


LevelController::~LevelController()
{
}
