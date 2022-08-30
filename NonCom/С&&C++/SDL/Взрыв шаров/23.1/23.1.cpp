
#define BALL_COUNT 5
#pragma comment(lib, "SDL2_mixer.lib")
#include <stdio.h>
#include <SDL.h>
#include <stdlib.h>
#include <locale>
#include "SDL_ttf.h"
#include <time.h>
#include "SDL_mixer.h"
#define SCREEN_WIDTH  600
#define  SCREEN_HEIGHT 720

#undef main

struct Ball {
	SDL_Rect ball;
	SDL_Texture* text;
	int point;
	SDL_Color fore = { 255,255,255 };
	SDL_Color back = { 200,15,0 };
};

SDL_Texture* get_text_texture(SDL_Renderer*& renderer, char* text, TTF_Font* font, SDL_Color fore_color, SDL_Color back_color)
{
	SDL_Surface* textSurface = TTF_RenderText_Shaded(font, text, fore_color, back_color);
	SDL_Texture* texture = SDL_CreateTextureFromSurface(renderer, textSurface);
	SDL_FreeSurface(textSurface);
	return texture;

}

void draw_balls(SDL_Renderer* &renderer, Ball balls[],int count, SDL_Texture* texture)
{
	for (int i = 0; i < count; i++)
	{
		if (balls[i].ball.w == 0) continue;
		SDL_Rect rect = balls[i].ball;
		rect.w /= 2;
		rect.h /= 2;
		rect.x = (2 * rect.x + rect.w) / 2;
		rect.y = (2 * rect.y + rect.h) / 2;
		SDL_RenderCopy(renderer, texture, NULL, &balls[i].ball);
		SDL_RenderCopy(renderer, balls[i].text, NULL, &rect);
	}
}


void init_balls(Ball balls [] , int count, SDL_Renderer*& renderer, TTF_Font* font)
{
	srand(time(NULL));
	int  x, y, r1, r2, d, l ,w,h,sum;
	
	
	for (int i = 0; i < count; i++)
	{
		
		sum = 0;
		balls[i].ball = { x = rand() % ((SCREEN_WIDTH - 100) - 100 + 1) + 100,y = rand() % (SCREEN_HEIGHT - 100) ,w=rand()%(150-30+1)+30 ,w };
		
		for (int u = 0; u < i; u++)
			sum += u+1 ;
		if (i > 0)
		do {
			l = 0;
			for (int j = 0; j < i; j++)
			{
				r1 = (balls[i].ball.w / 2)*(balls[i].ball.w / 2);
				r2 = (balls[j].ball.w / 2)* (balls[j].ball.w / 2);
				d = ((balls[j].ball.x + balls[j].ball.w / 2) - (balls[i].ball.x + balls[i].ball.w / 2))* ((balls[j].ball.x + balls[j].ball.w / 2) - (balls[i].ball.x + balls[i].ball.w / 2)) + ((balls[j].ball.y + balls[j].ball.h / 2) - (balls[i].ball.y + balls[i].ball.h / 2))* ((balls[j].ball.y + balls[j].ball.h / 2) - (balls[i].ball.y + balls[i].ball.h / 2));
				if ((r1 + r2) >= d - 10000) 
				{
					balls[i].ball = { x = rand() % ((SCREEN_WIDTH - 100) - 100 + 1) + 100,y = rand() % (SCREEN_HEIGHT - 100) ,w = rand() % (150-30+1)+30 ,w };
					
					l = 0;

				}
				else l+=(j+1);
				

			}
		} while (l!=sum);
		balls[i].point = rand()%(10-1+1)+1;
		char text[10];
		_itoa_s(balls[i].point, text, 10);
		balls[i].text = get_text_texture(renderer, text, font, balls[i].fore, balls[i].back);
	}
}

bool is_ball_hit(SDL_Rect ball, int x, int y)
{
	if (ball.w == 0) return false;
	int centerX = ball.x + ball.w / 2;
	int centerY = ball.y + ball.h / 2;
	int radius = ball.w / 2;
	return sqrt((centerX - x)*(centerX - x) + (centerY - y)*(centerY - y)) < radius;
}



void draw_text(SDL_Renderer* &renderer, SDL_Texture* texture)
{
	SDL_Rect rect = { 0,0, 70, 200 };
	SDL_RenderCopy(renderer, texture, NULL, &rect);
}


void loadmusic(Mix_Music* fon)
{

	fon  = Mix_LoadMUS("march.wav");
	Mix_PlayMusic(fon, -1);
}

void sound(Mix_Chunk* Sound)
{
	Sound = Mix_LoadWAV("1.wav");
	Mix_PlayChannel(-1, Sound, 0);
}




int main(int argc, char** argv)
{
	int count = BALL_COUNT;
	Ball balls[BALL_COUNT];
	srand(time(NULL));
	SDL_Init(SDL_INIT_EVERYTHING);
	Mix_Init(0);
	Mix_OpenAudio(22050, MIX_DEFAULT_FORMAT, 2, 1024);

	SDL_Window* window = SDL_CreateWindow("Click the balls",
		SDL_WINDOWPOS_CENTERED, SDL_WINDOWPOS_CENTERED,
		SCREEN_WIDTH, SCREEN_HEIGHT, SDL_WINDOW_SHOWN);
	SDL_Renderer* renderer = SDL_CreateRenderer(window, -1, 0);
	TTF_Init();
	TTF_Font* my_font = TTF_OpenFont("Text.ttf", 100);
	SDL_Texture* textTexture;


	init_balls(balls, count,renderer, my_font);

	SDL_Surface *ballImage = SDL_LoadBMP("1.bmp");
	SDL_SetColorKey(ballImage, SDL_TRUE,SDL_MapRGB(ballImage->format, 0, 0, 0));
	SDL_Texture *ballTexture = SDL_CreateTextureFromSurface(renderer, ballImage);
	SDL_FreeSurface(ballImage);

	
	
	Mix_Chunk* Sound = NULL;
	Mix_Music* fon = NULL;


	
	int k = 0;
	char text[10];
	_itoa_s(k, text, 10);
	SDL_Color fore_color = { 13,169,123 };
	SDL_Color back_color = { 50,50,200 };
	textTexture = get_text_texture(renderer, text, my_font, fore_color, back_color);

	SDL_Event event;
	bool quit = false;
	loadmusic(fon);
	while (!quit)
	{
		while (SDL_PollEvent(&event)) {
			if (event.type == SDL_QUIT)
				quit = true;
			if (event.type == SDL_MOUSEBUTTONDOWN &&
				event.button.button == SDL_BUTTON_LEFT)
			{
				for (int i = 0; i < BALL_COUNT; i++)
				{
					
					if (is_ball_hit(balls[i].ball, event.button.x, event.button.y))
					{
						sound(Sound);
						--count;
						balls[i].ball.w = balls[i].ball.h = 0;
						k += balls[i].point;
						_itoa_s(k, text, 10);
						SDL_DestroyTexture(textTexture);
						SDL_DestroyTexture(balls[i].text);
						textTexture = get_text_texture(renderer, text, my_font, fore_color, back_color);
						
						
					}
				}
				init_balls(balls, count, renderer, my_font);
				draw_balls(renderer, balls, count, ballTexture);
				
			}
			
		}

		SDL_SetRenderDrawColor(renderer, 0, 0, 0, 0);
		SDL_RenderClear(renderer);

		draw_balls(renderer, balls, count, ballTexture);
		draw_text(renderer, textTexture);
		
		SDL_RenderPresent(renderer);
		
	}
	Mix_FreeMusic(fon);
	Mix_FreeChunk(Sound);
	Mix_CloseAudio();

	SDL_DestroyTexture(textTexture);

	SDL_DestroyTexture(ballTexture);
	TTF_CloseFont(my_font);
	TTF_Quit();
	SDL_DestroyRenderer(renderer);
	SDL_DestroyWindow(window);
	SDL_Quit();
	return 0;
}
