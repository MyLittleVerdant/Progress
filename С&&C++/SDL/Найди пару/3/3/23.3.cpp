#define _CRT_SECURE_NO_WARNINGS
#include <stdio.h>
#include <SDL.h>
#include <stdlib.h>
#include <locale>
#include "SDL_image.h"
#include "SDL_ttf.h"
#include <time.h>
#define SCREEN_WIDTH  1120
#define  SCREEN_HEIGHT 700
#undef main
struct card {
	int id;
	SDL_Rect pic;
	SDL_Texture* frontTexture;
	int state = 0;
};

SDL_Texture* get_text_texture(SDL_Renderer*& renderer, char* text, TTF_Font* font, SDL_Color fore_color, SDL_Color back_color)
{
	SDL_Surface* textSurface = TTF_RenderText_Shaded(font, text, fore_color, back_color);
	SDL_Texture* texture = SDL_CreateTextureFromSurface(renderer, textSurface);
	SDL_FreeSurface(textSurface);
	return texture;

}

void draw_text(SDL_Renderer*& renderer, SDL_Texture* texture)
{
	SDL_Rect rect = { 0,0, 64, 75 };
	SDL_RenderCopy(renderer, texture, NULL, &rect);
}

int  check(int a[3][4])
{
	int o = 0, d = 0, t = 0, c = 0, p = 0, s = 0;
	for (int l = 0; l < 3; l++)
		for (int m = 0; m < 4; m++)
		{
			switch (a[l][m])
			{
			case 1:o++; break;
			case 2:d++; break;
			case 3:t++; break;
			case 4:c++; break;
			case 5:p++; break;
			case 6:s++; break;
			}
		}
	if (o != 2)
		return 0;
	else if (d != 2)
		return 0;
	else if (t != 2)
		return 0;
	else if (c != 2)
		return 0;
	else if (p != 2)
		return 0;
	else if (s != 2)
		return 0;
	else return 1;
}

int create(int a[3][4] )
{
	int ch;
	for (int i = 0; i < 3; i++)
		for (int j = 0; j < 4; j++)
		{
			a[i][j] = rand() % (6 - 1 + 1) + 1;
			
		}
	ch = check(a);
	if (ch == 0)
		return create(a);
	else return 1;
}

void output(int a[3][4])
{
	for (int i = 0; i < 3; i++)
	{
		for (int j = 0; j < 4; j++)
		{
			printf("%3d", a[i][j]);
		}
		printf("\n");
	}
}

void init_cards(int a[3][4],card cards[], SDL_Renderer*& renderer)
{
	char idtext[] = " .JPG";
	for (int i = 0; i < 3; i++)
		for (int j = 0; j < 4; j++)
		{

			cards[i * 4 + j].id = a[i][j];
			cards[i * 4 + j].pic = { 64 + 264 * j,20 + 220 * i,200,200 };

			idtext[0] = cards[i * 4 + j].id + 48;

			SDL_Surface* front = IMG_Load(idtext);
			cards[i * 4 + j].frontTexture = SDL_CreateTextureFromSurface(renderer, front);
			SDL_FreeSurface(front);
			
		}
}

void draw_cards(SDL_Renderer* &renderer,card cards[], SDL_Texture* backTexture)
{
	
	SDL_Texture* temp;
	for (int i = 0; i < 3; i++)
		for (int j = 0; j < 4; j++)
		{
			temp = backTexture;
			if (cards[i * 4 + j].state) 
				temp = cards[i * 4 + j].frontTexture;
			SDL_RenderCopy(renderer, temp, NULL, &cards[i * 4 + j].pic); 
			
			
		}
	
	

}

bool is_card_hit(SDL_Rect pic, int x, int y)
{
	return (pic.x < x && pic.x + pic.w > x && pic.y < y && pic.y + pic.h > y);
		
	
}

/*void flip_card(int order, card cards[], int a[3][4], SDL_Renderer*& renderer)
{
	cards[order].backloc.w = cards[order].backloc.h = 0;
	SDL_RenderCopy(renderer, cards[order].backTexture, NULL, &cards[order].backloc);

}*/

int main(int argc, char** argv)
{
	int a[3][4];
	int k = 0;
	int attempts = 20;
	int countcards = 0;
	char text[10];
	struct card cards[12];
	srand(time(NULL));
	SDL_Init(SDL_INIT_EVERYTHING);
	SDL_Window* window = SDL_CreateWindow("Find a Pair",
		SDL_WINDOWPOS_CENTERED, SDL_WINDOWPOS_CENTERED,
		SCREEN_WIDTH, SCREEN_HEIGHT, SDL_WINDOW_SHOWN);
	SDL_Renderer* renderer = SDL_CreateRenderer(window, -1, 0);

	

	SDL_Surface* Fon = IMG_Load("Screen.bmp");
	SDL_Texture* FonTexture = SDL_CreateTextureFromSurface(renderer, Fon);
	SDL_FreeSurface(Fon);
	SDL_Rect Screen = { 0,0,SCREEN_WIDTH,700 };
	SDL_RenderCopy(renderer, FonTexture, NULL, &Screen);
	
	SDL_Surface* back = IMG_Load("Back.JPG");
	SDL_Texture* backTexture = SDL_CreateTextureFromSurface(renderer, back);
	SDL_FreeSurface(back);

	TTF_Init();
	TTF_Font* my_font = TTF_OpenFont("Text.ttf", 100);
	SDL_Texture* textTexture;

	SDL_Color fore_color = { 13,169,123 };
	SDL_Color back_color = { 50,50,200 };

	_itoa_s(attempts, text, 10);
	textTexture = get_text_texture(renderer, text, my_font, fore_color, back_color);

	create(a);
	output(a);

	init_cards(a, cards, renderer);


	SDL_Event event;
	bool quit = false;
	bool flag = false;
	int point1 = 0;
	int point2 = 0;
	
	while (!quit&&attempts&&countcards<6)
	{
		while (SDL_PollEvent(&event)) {
			if (event.type == SDL_QUIT)
				quit = true;
			if (flag) {
				flag = false;
				cards[point2].state = cards[point1].state = 0;
				SDL_Delay(500);
			}
			if (event.type == SDL_MOUSEBUTTONDOWN && event.button.button == SDL_BUTTON_LEFT)
			{
				for (int i = 0; i < 3; i++)
					for (int j = 0; j < 4; j++)
					{
						if (is_card_hit(cards[i * 4 + j].pic, event.button.x, event.button.y)&&cards[i * 4 + j].state!=2)
						{
							attempts--;
							_itoa_s(attempts, text, 10);
							textTexture = get_text_texture(renderer, text, my_font, fore_color, back_color);
							if (k == 0) {
								k = 1;
								point1 = i * 4 + j;
								cards[i * 4 + j].state = 1;
							}
							else {
								if (cards[i * 4 + j].id == cards[point1].id) {
									cards[i * 4 + j].state = cards[point1].state = 2;
									countcards++;
								}
								else {
									flag = true;
									point2 = i * 4 + j;
									cards[i * 4 + j].state = 1;
								}
								k = 0;

							}
						}
					}
			}
		}




		
		draw_text(renderer, textTexture);
		draw_cards(renderer, cards,backTexture);
		SDL_RenderPresent(renderer);
		
	}
	char finaltext[] = "The number of the guessed cards:   ";
	char temptext[5];
	int i = 0;
	quit = false;
	SDL_RenderCopy(renderer, FonTexture, NULL, &Screen);
	
	finaltext[34] = countcards+48;
		
	
	textTexture = get_text_texture(renderer, finaltext, my_font, fore_color, back_color);
	SDL_Rect rect = { 200,300, 800, 100 };
	SDL_RenderCopy(renderer, textTexture, NULL, &rect);
	SDL_RenderPresent(renderer);
	while (!quit) {
		while (SDL_PollEvent(&event)) {
			if (event.type == SDL_QUIT)
				quit = true;
		}

	}
	SDL_DestroyTexture(FonTexture);
	SDL_DestroyTexture(backTexture);
	SDL_DestroyTexture(textTexture);
	TTF_CloseFont(my_font);
	TTF_Quit();
	SDL_DestroyRenderer(renderer);
	SDL_DestroyWindow(window);
	SDL_Quit();
}