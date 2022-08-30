#define _CRT_SECURE_NO_WARNINGS
#pragma comment(lib, "SDL2_mixer.lib")
#include <iostream>
#include <SDL.h>
#include "SDL_image.h"
#include "SDL_ttf.h"
#include <time.h>
#include "SDL_mixer.h"
#define SCREEN_WIDTH  1280
#define  SCREEN_HEIGHT 720
#undef main

struct line {
	int x1, y1, x2, y2;
};

struct cell {
	cell* A;
	SDL_Rect coord;
	line up;
	line right;
	bool upwhite = false;
	bool rightwhite = false;
	bool upblack = true;
	bool rightblack = true;
	int quantity;
	int cell_size = 50;

}map;

struct hero {
	SDL_Texture* HERO;
	SDL_Rect body ;
	int step = 50;
	int points = 0;
}ghost,ghost2;
struct bonus {
	SDL_Texture* ingot;
	SDL_Rect place ;
	int points;
	bool taken = false;
};
struct menuicon {
	SDL_Rect icon;
	SDL_Texture* choiceTexture;
	int id;
};
struct rating {
	char name[20];
	char score[10];
}Table[10];

void InitMap(cell* s, int l) // инициализаци€ стека из l элементов
{
	if (s->A = (cell*)malloc(sizeof(cell) * l * l))
	{
		s->quantity = l * l;
	}
	else s->quantity = -1;

	for (int i = 0; i < l; i++)
		for (int j = 0; j < l; j++)
		{
			s->A[i * l + j].coord = { 50 * j,50 * i,50,50 };
			s->A[i * l + j].up = { s->A[i * l + j].coord.x,s->A[i * l + j].coord.y,s->A[i * l + j].coord.x + 50,s->A[i * l + j].coord.y };
			s->A[i * l + j].right = { s->A[i * l + j].coord.x + 50,s->A[i * l + j].coord.y,s->A[i * l + j].coord.x + 50,s->A[i * l + j].coord.y + 50 };
		}
}

void DrawMap(cell s, SDL_Renderer*& renderer, int N)
{
	SDL_SetRenderDrawColor(renderer, 0, 0, 0, 0);

	for (int i = 0; i < N; i++)
		for (int j = 0; j < N; j++)
		{
			SDL_RenderDrawLine(renderer, s.A[i * N + j].coord.x, s.A[i * N + j].coord.y, s.A[i * N + j].coord.x + 50, s.A[i * N + j].coord.y);
			SDL_RenderDrawLine(renderer, s.A[i * N + j].coord.x + 50, s.A[i * N + j].coord.y, s.A[i * N + j].coord.x + 50, s.A[i * N + j].coord.y + 50);

		}
	int i = N - 1;
	for (int j = 0; j < N; j++)
	SDL_RenderDrawLine(renderer, s.A[i * N + j].coord.x, s.A[i * N + j].coord.y+50, s.A[i * N + j].coord.x + 50, s.A[i * N + j].coord.y+50);
	
}

void InitMaze(cell* s, SDL_Renderer * &renderer, int N)
{
	srand(time(NULL));
	int rarr, rexit,count=N,rdir;
	SDL_SetRenderDrawColor(renderer, 255, 255, 255, 0);
	for (int i = 0; i < N; i++)
	{
		for (int j = 0; j < N; j++)
		{
			if (i == 0 && j != N - 1)
			{
				//s->A[i * N + j].rightwhite = true;
				s->A[i * N + j].rightblack = false;
				//SDL_RenderDrawLine(renderer, map.A[i * N + j].coord.x + 40, map.A[i * N + j].coord.y + 1, map.A[i * N + j].coord.x + 40, map.A[i * N + j].coord.y + 39); //очищаем первую строку
			}
			
			else if (i != 0)
			{
				rarr = rand() % (count - 1 + 1) + 1;
				count -= rarr;
				if (rarr > 1) // дл€ массива
				{
					for (int c = j; c < N - count - 1; c++)
					{
						//s->A[i * N + c].rightwhite = true;
						s->A[i * N + c].rightblack = false;
						//SDL_RenderDrawLine(renderer, map.A[i * N + c].coord.x + 40, map.A[i * N + c].coord.y + 1, map.A[i * N + c].coord.x + 40, map.A[i * N + c].coord.y + 39); // соедин€ем массив

					}
					rexit = rand() % ((N - count-1) - j + 1) + j;
					j += rarr - 1;
					//s->A[i * N + rexit].upwhite = true;
					s->A[i * N + rexit].upblack = false;
					//SDL_RenderDrawLine(renderer, map.A[i * N + rexit ].coord.x+1 , map.A[i * N + rexit ].coord.y, map.A[i * N + rexit ].coord.x + 39, map.A[i * N + rexit ].coord.y); // выбираем клетку дл€ выхода

				}
				else //дл€ 1 клетки
				{
					if (j == N - 1) // если последн€€ всегда вверх
					{
						//s->A[i * N + j].upwhite = true;
						s->A[i * N + j].upblack = false;
						//SDL_RenderDrawLine(renderer, map.A[i * N + j].coord.x + 1, map.A[i * N + j].coord.y, map.A[i * N + j].coord.x + 39, map.A[i * N + j].coord.y);
					}
					else // иначе выбор вверх/право
					{
						rdir = rand() % 1;
						if (rdir == 0)
						{
							//s->A[i * N + j].rightwhite = true;
							s->A[i * N + j].rightblack = false;
							//SDL_RenderDrawLine(renderer, map.A[i * N + j].coord.x + 40, map.A[i * N + j].coord.y + 1, map.A[i * N + j].coord.x + 40, map.A[i * N + j].coord.y + 39);// right
						}
						else
						{
							//s->A[i * N + j].upwhite = true;
							s->A[i * N + j].upblack = false;
							//SDL_RenderDrawLine(renderer, map.A[i * N + j].coord.x + 1, map.A[i * N + j].coord.y, map.A[i * N + j].coord.x + 39, map.A[i * N + j].coord.y);// up
						}
							
					}
					
				}
			}
			 if (i == N - 1 && j == N - 1)
			 {
				// s->A[i * N + j].rightwhite = true;
				 s->A[i * N + j].rightblack = false;
				//SDL_RenderDrawLine(renderer, map.A[i * N + j].coord.x + 40, map.A[i * N + j].coord.y + 1, map.A[i * N + j].coord.x + 40, map.A[i * N + j].coord.y + 39);
			 }
			
		}
		count = N;
	}
	
}

void DrawMaze(cell s, SDL_Renderer*& renderer, int N, SDL_Texture* Exit, SDL_Rect exitplace, SDL_Rect exitplace2)
{
	SDL_SetRenderDrawColor(renderer, 255, 255, 255, 0);
	for (int i = 0; i < N; i++)
		for (int j = 0; j < N; j++)
		{
			if (s.A[i * N + j].rightblack==false)
			{
				SDL_RenderDrawLine(renderer, s.A[i * N + j].coord.x + 50, s.A[i * N + j].coord.y + 1, s.A[i * N + j].coord.x + 50, s.A[i * N + j].coord.y + 49);
			}
			if (s.A[i * N + j].upblack==false)
			{
				SDL_RenderDrawLine(renderer, s.A[i * N + j].coord.x + 1, s.A[i * N + j].coord.y, s.A[i * N + j].coord.x + 49, s.A[i * N + j].coord.y);
			}
		}

	SDL_RenderCopy(renderer, Exit, NULL, &exitplace);
	SDL_RenderCopy(renderer, Exit, NULL, &exitplace2);
	
}

bool MayIMoveUp(cell  s, hero a,int N)
{
	int x = a.body.x / 50;
	int y = a.body.y / 50;
	return !s.A[y * N + x].upblack;
		

	
}
bool MayIMoveDown(cell  s, hero a, int N)
{
	int x = a.body.x / 50;
	int y = a.body.y / 50;
	return !s.A[(y+1) * N + x].upblack;
}
bool MayIMoveRight(cell  s, hero a, int N)
{

	int x = a.body.x / 50;
	int y = a.body.y / 50;
	return !s.A[y * N + x].rightblack;
}
bool MayIMoveLeft(cell  s, hero a, int N)
{

	int x = a.body.x / 50;
	int y = a.body.y / 50;
	return !s.A[y * N + x-1].rightblack;
}

SDL_Texture* get_text_texture(SDL_Renderer*& renderer, char* text, TTF_Font* font, SDL_Color fore_color, SDL_Color back_color)
{
	SDL_Surface* textSurface = TTF_RenderText_Shaded(font, text, fore_color, back_color);
	SDL_Texture* texture = SDL_CreateTextureFromSurface(renderer, textSurface);
	SDL_FreeSurface(textSurface);
	return texture;

}

void DrawCreature(hero* s, SDL_Renderer*& renderer, int N, bonus gold,bonus silver, bonus bronze, SDL_Texture* Exit, SDL_Rect exitplace, SDL_Rect exitplace2)
{
	SDL_RenderClear(renderer);
	DrawMap(map, renderer, N);
	DrawMaze(map, renderer, N,Exit,exitplace, exitplace2);
	SDL_RenderCopy(renderer, gold.ingot, NULL, &gold.place);
	SDL_RenderCopy(renderer, silver.ingot, NULL, &silver.place);
	SDL_RenderCopy(renderer, bronze.ingot, NULL, &bronze.place);
	SDL_RenderCopy(renderer, s->HERO, NULL, &s->body);
}
void DrawCreatures(hero* s, hero* s2, SDL_Renderer*& renderer, int N, bonus gold, bonus silver, bonus bronze, SDL_Texture* Exit, SDL_Rect exitplace, SDL_Rect exitplace2)
{
	SDL_RenderClear(renderer);
	DrawMap(map, renderer, N);
	DrawMaze(map, renderer, N, Exit, exitplace, exitplace2);
	SDL_RenderCopy(renderer, gold.ingot, NULL, &gold.place);
	SDL_RenderCopy(renderer, silver.ingot, NULL, &silver.place);
	SDL_RenderCopy(renderer, bronze.ingot, NULL, &bronze.place);
	SDL_RenderCopy(renderer, s->HERO, NULL, &s->body);
	SDL_RenderCopy(renderer, s2->HERO, NULL, &s2->body);
}

int IsBonusReached( hero* a, bonus gold, bonus silver, bonus bronze)
{
	int x = a->body.x / 50;
	int y = a->body.y / 50;
	if (x == (gold.place.x - 10) / 50 && y == (gold.place.y - 10) / 50)
	{
		return 1;
	}else if(x == (silver.place.x - 10) / 50 && y == (silver.place.y - 10) / 50)
	{
		return 2;
		
	}else if(x == (bronze.place.x - 10) / 50 && y == (bronze.place.y - 10) / 50)
	{
		return 3;
	}
}

bool is_card_hit(SDL_Rect pic, int x, int y)
{
	return (pic.x < x && pic.x + pic.w > x && pic.y < y && pic.y + pic.h > y);


}

void RatingTable(rating Table[])
{
	char name[50];
	printf("Enter your name: \n");
	gets_s(name);
	printf("Do you want to see rating table?"
		"\n"
		"Yes-1         No-2"
	);
	int m;
	scanf("%d", &m);
	
		char table[10][50];
		FILE* TextTable = fopen("Score.txt", "r+");

		for (int i = 0; i < 10; i++)
		{
			fgets(table[i], 50, TextTable);
		}
		int j=0;
		int k = 0;
		for (int i = 0; i < 10; i++)
		{
			while (table[i][j]!=' ')
			{
				Table[i].name[j] = table[i][j];
				j++;
			}
			Table[i].name[j] = '\0';
			while (table[i][j] != '\0')
			{
				Table[i].score[k] = table[i][j];
			}
		}
		if (m == 1)
		for (int i = 0; i < 10; i++)
		{
			puts(table[i]);

		}
	    
}

/*void sort(rating Table[])
{
	int a,b,c;
	char* tempname, tempscore[10];

	for (int i = 0; i < 10; i++)
	{
		a=atoi(Table[i].score);
		b = atoi(Table[i+1].score);
		if (a < b)
		{
			tempname = Table[i].name;
			memset(Table[i].name, ' ', 20);
			while()
			Table[i].name= Table[i+1].name

		}
	}
}*/
int chooseskin(menuicon poke[], SDL_Renderer*& renderer, SDL_Texture* textTexture, TTF_Font* my_font, SDL_Color fore_color, SDL_Color back_color,SDL_Event event, SDL_Window* window2)
{
	bool quit = false;
	char Choice[] = "Choose your character";
	textTexture = get_text_texture(renderer, Choice, my_font, fore_color, back_color);


	char nametext[] = "gastly .PNG";
	for (int i = 0; i < 3; i++)
	{
		nametext[6] = i + 49;
		SDL_Surface* choice = IMG_Load(nametext);
		poke[i].choiceTexture = SDL_CreateTextureFromSurface(renderer, choice);
		SDL_FreeSurface(choice);

		poke[i].id = i;
		poke[i].icon = { 130 + i * 380,180,250,250 };

		SDL_RenderCopy(renderer, poke[i].choiceTexture, NULL, &poke[i].icon);

	}

	char nametext2[] = "Haunter .PNG";
	for (int i = 0; i < 3; i++)
	{
		nametext2[7] = i + 49;
		SDL_Surface* choice = IMG_Load(nametext2);
		poke[i + 3].choiceTexture = SDL_CreateTextureFromSurface(renderer, choice);
		SDL_FreeSurface(choice);

		poke[i + 3].id = i + 3;
		poke[i + 3].icon = { 130 + i * 380,450,250,250 };

		SDL_RenderCopy(renderer, poke[i + 3].choiceTexture, NULL, &poke[i + 3].icon);

	}

	SDL_Rect rect = { 250,25, 800, 100 };
	SDL_RenderCopy(renderer, textTexture, NULL, &rect);

	SDL_RenderPresent(renderer);


	int flagchoose = -1;
	while (!quit && flagchoose == -1) {
		while (SDL_PollEvent(&event)) {
			if (event.type == SDL_QUIT)
				quit = true;
			if (event.type == SDL_MOUSEBUTTONDOWN &&
				event.button.button == SDL_BUTTON_LEFT)
			{
				for (int i = 0; i < 6; i++)
				{
					if (is_card_hit(poke[i].icon, event.button.x, event.button.y))
					{
						flagchoose = poke[i].id;

					}
				}
			}
		}

	}
	
	return flagchoose;
}


void Final(Mix_Music* FinalScore)
{

	FinalScore = Mix_LoadMUS("FinalScore.wav");
	Mix_PlayMusic(FinalScore, -1);
}
void Hit(Mix_Chunk* Hit)
{
	Hit = Mix_LoadWAV("Hit.wav");
	Mix_PlayChannel(-1,Hit, 0);
}
void PickBonus(Mix_Chunk* Bonus)
{
	Bonus = Mix_LoadWAV("Bonus.wav");
	Mix_PlayChannel(-1, Bonus, 0);
}

void main()
{
	
	bonus gold, silver, bronze;
	menuicon poke[6];
	menuicon number[2];
	int N;
	Mix_Chunk* Bonus = NULL;
	Mix_Chunk* Knock = NULL;
	Mix_Music* FinalScore = NULL;
	bool flag = false;
	bool flag2 = false;
	int counter,counter2 ;
	printf("Enter the field size: ");
	scanf("%d", &N); //размер пол€
	int d;
	printf("To begin from the middle(1) or edge of the card(2)? ");
	do {
		scanf("%d", &d);
		if (d < 1 || d>2)
			printf("Incorrect data. Try again.\n");
	} while (d < 1 || d>2);
	if (d == 1)
	{
		ghost.body = { N / 2 * map.cell_size+5,N / 2 * map.cell_size+5,40,40 };
		ghost2.body = { N /2 * map.cell_size + 5,N/2 * map.cell_size + 5,40,40 };
	}
	else { ghost.body = { 5,5,40,40 }; ghost2.body = { (N - 1) * map.cell_size + 5,(N - 1) * map.cell_size + 5,40,40 }; }
	InitMap(&map, N);
	counter = 10 * N; //очки
	counter2 = 10 * N;
	int Width = N * map.cell_size; //размер пол€
	int Height= N * map.cell_size;
	
	SDL_Init(SDL_INIT_EVERYTHING);
	TTF_Init();
	TTF_Font* my_font = TTF_OpenFont("Text.ttf", 100);
	SDL_Texture* textTexture;
	Mix_Init(0);
	Mix_OpenAudio(22050, MIX_DEFAULT_FORMAT, 2, 1024);

	SDL_Color fore_color = { 0,0,0 };
	SDL_Color back_color = { 255,255,255 };

	SDL_Window* window2 = SDL_CreateWindow("Menu",
		SDL_WINDOWPOS_CENTERED, SDL_WINDOWPOS_CENTERED,
		SCREEN_WIDTH, SCREEN_HEIGHT, SDL_WINDOW_SHOWN);
	SDL_Renderer* renderer2 = SDL_CreateRenderer(window2, -1, 0);
	SDL_SetRenderDrawColor(renderer2, 255, 255, 255, 0);
	SDL_RenderClear(renderer2);

	SDL_Event event;
	bool quit = false;
	SDL_Rect rect = { 200,25, 800, 100 };
	char countplayer[] = "1 or 2 players?";
	textTexture = get_text_texture(renderer2, countplayer, my_font, fore_color, back_color);
	SDL_RenderCopy(renderer2, textTexture, NULL, &rect);
	
	char one[] = "1";
	char two[] = "2";
	number[0].choiceTexture = get_text_texture(renderer2, one, my_font, fore_color, back_color);
	number[1].choiceTexture = get_text_texture(renderer2, two, my_font, fore_color, back_color);
	
	number[0].icon = { 300, 300, 100,100 };
	number[1].icon = { 700,300,100,100 };
	SDL_RenderCopy(renderer2, number[0].choiceTexture, NULL, &number[0].icon);
	SDL_RenderCopy(renderer2, number[1].choiceTexture, NULL, &number[1].icon);
	SDL_RenderPresent(renderer2);
	int numberplayer=-1;
    while (!quit&& numberplayer==-1) {
		while (SDL_PollEvent(&event))
		{
			if (event.type == SDL_QUIT)
				quit = true;
			if (event.type == SDL_MOUSEBUTTONDOWN && event.button.button == SDL_BUTTON_LEFT)
			{
				if (event.button.x > number[0].icon.x && event.button.x< number[0].icon.x + 100 && event.button.y>number[0].icon.y && event.button.y < number[0].icon.y + 100)
				{
					numberplayer = 1;
				}
				if (event.button.x > number[1].icon.x && event.button.x< number[1].icon.x + 100 && event.button.y>number[1].icon.y && event.button.y < number[1].icon.y + 100)
				{
					numberplayer = 2;
				}
			}
		}

    }
	SDL_RenderClear(renderer2);
	SDL_RenderPresent(renderer2);

	if (numberplayer == 1)
	{
	
		int flag1;
		flag1 = chooseskin(poke, renderer2, textTexture, my_font, fore_color, back_color, event, window2);
		SDL_DestroyRenderer(renderer2);
		SDL_DestroyWindow(window2);

		SDL_Window* window = SDL_CreateWindow("Maze",
			SDL_WINDOWPOS_CENTERED, SDL_WINDOWPOS_CENTERED,
			Width, Height, SDL_WINDOW_SHOWN);
		SDL_Renderer* renderer = SDL_CreateRenderer(window, -1, 0);
		SDL_SetRenderDrawColor(renderer, 255, 255, 255, 0);
		SDL_RenderClear(renderer);




		SDL_Surface* exit = IMG_Load("Exit.PNG");
		SDL_Texture* Exit = SDL_CreateTextureFromSurface(renderer, exit);
		SDL_FreeSurface(exit);

		SDL_Rect exitplace = { (N - 1) * map.cell_size,(N - 1) * map.cell_size,map.cell_size ,map.cell_size };
		char nametext[] = "gastly .PNG";
		char nametext2[] = "Haunter .PNG";

		if (flag1 < 3)
		{
			nametext[6] = flag1 + 49;
			SDL_Surface* ghostsur = IMG_Load(nametext);
			ghost.HERO = SDL_CreateTextureFromSurface(renderer, ghostsur);
			SDL_FreeSurface(ghostsur);
		}
		else if (flag1 > 2)
		{
			nametext2[7] = flag1 + 46;
			SDL_Surface* ghostsur = IMG_Load(nametext2);
			ghost.HERO = SDL_CreateTextureFromSurface(renderer, ghostsur);
			SDL_FreeSurface(ghostsur);
		}

		SDL_Surface * Gold = IMG_Load("gold.PNG");
		gold.ingot = SDL_CreateTextureFromSurface(renderer, Gold);
		SDL_FreeSurface(Gold);
		gold.points = 15;
		SDL_Surface* Silver = IMG_Load("silver.PNG");
		silver.ingot = SDL_CreateTextureFromSurface(renderer, Silver);
		SDL_FreeSurface(Silver);
		silver.points = 10;

		SDL_Surface* Bronze = IMG_Load("bronze.PNG");
		bronze.ingot = SDL_CreateTextureFromSurface(renderer, Bronze);
		SDL_FreeSurface(Bronze);
		bronze.points = 5;


		gold.place = { (rand() % N * 50) + 10,(rand() % N * 50) + 10,30,30 };
		silver.place = { (rand() % N * 50) + 10, (rand() % N * 50) + 10,30,30 };
		bronze.place = { (rand() % N * 50) + 10, (rand() % N * 50) + 10,30,30 };

		bool check = false;

		quit = false;

		DrawMap(map, renderer, N);
		InitMaze(&map, renderer, N);
		SDL_Rect exitplace2 = {0,0,0,0};
		DrawMaze(map, renderer, N, Exit, exitplace,exitplace2);

		SDL_RenderPresent(renderer);


		while (!quit && ghost.body.x < Width)
		{
			while (SDL_PollEvent(&event)) {
				if (event.type == SDL_QUIT)
					quit = true;
				if (event.type == SDL_KEYDOWN && event.key.keysym.sym == SDLK_w)
				{
					counter--;
					if (ghost.body.y >= 0 && MayIMoveUp(map, ghost, N) == true) {
						ghost.body.y -= ghost.step;
						DrawCreature(&ghost, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
					}
					else if (MayIMoveDown(map, ghost, N) == true) {
						ghost.body.y += map.cell_size; DrawCreature(&ghost, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
						Hit(Knock);//sound
					}
					else {
						Hit(Knock);//sound
					}

				}
				if (event.type == SDL_KEYDOWN && event.key.keysym.sym == SDLK_s)
				{
					counter--;
					if (ghost.body.y < SCREEN_HEIGHT && MayIMoveDown(map, ghost, N) == true)
					{
						ghost.body.y += ghost.step;
						DrawCreature(&ghost, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
					}
					else if (MayIMoveUp(map, ghost, N) == true) {
						ghost.body.y -= map.cell_size; DrawCreature(&ghost, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
						Hit(Knock);//sound
					}
					else {
						Hit(Knock);//sound
					}
				}

				if (event.type == SDL_KEYDOWN && event.key.keysym.sym == SDLK_a)
				{
					counter--;
					if (ghost.body.x > 0 && MayIMoveLeft(map, ghost, N) == true) {
						ghost.body.x -= ghost.step;
						DrawCreature(&ghost, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
					}
					else if (MayIMoveRight(map, ghost, N) == true) {
						ghost.body.x += map.cell_size; DrawCreature(&ghost, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
						Hit(Knock);//sound
					}
					else {
						Hit(Knock);//sound
					}
				}

				if (event.type == SDL_KEYDOWN && event.key.keysym.sym == SDLK_d)
				{
					counter--;
					if (ghost.body.x < SCREEN_WIDTH && MayIMoveRight(map, ghost, N) == true) {
						ghost.body.x += ghost.step;
						DrawCreature(&ghost, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
					}
					else if (MayIMoveLeft(map, ghost, N) == true) {
						ghost.body.x -= map.cell_size; DrawCreature(&ghost, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
						Hit(Knock);//sound
					}
					else {
						Hit(Knock);//sound
					}
				}

				if (IsBonusReached(&ghost, gold, silver, bronze) == 1 && gold.taken == false)
				{
					PickBonus(Bonus);
					SDL_DestroyTexture(gold.ingot);
					ghost.points += gold.points;
					gold.taken = true;
				}
				else if (IsBonusReached(&ghost, gold, silver, bronze) == 2 && silver.taken == false)
				{
					PickBonus(Bonus);
					SDL_DestroyTexture(silver.ingot);
					ghost.points += silver.points;
					silver.taken = true;
				}
				else if (IsBonusReached(&ghost, gold, silver, bronze) == 3 && bronze.taken == false)
				{
					PickBonus(Bonus);
					SDL_DestroyTexture(bronze.ingot);
					ghost.points += bronze.points;
					bronze.taken = true;
				}
				if (ghost.body.x >= Width && check == false)
				{
					
					ghost.points += 50; check = true;
					flag = true;
				}

			}



			DrawCreature(&ghost, renderer, N, gold, silver, bronze, Exit, exitplace,  exitplace2);

			SDL_RenderPresent(renderer);
		}
		if (flag == true) // окно результата
		{
			Final(FinalScore);
			ghost.points += counter;
			SDL_DestroyWindow(window);
			SDL_Window* window1 = SDL_CreateWindow("Total", SDL_WINDOWPOS_CENTERED, SDL_WINDOWPOS_CENTERED, 800, 100, SDL_WINDOW_SHOWN);
			SDL_Renderer* renderer1 = SDL_CreateRenderer(window1, -1, 0);
			SDL_SetRenderDrawColor(renderer, 255, 255, 255, 0);

			int i = 0;
			char finaltext[] = "Total score:         ";
			char temptext[5];
			_itoa_s(ghost.points, temptext, 10);
			while (temptext[i] != '\0')
			{
				finaltext[i + 13] = temptext[i];
				i++;
			}
			textTexture = get_text_texture(renderer1, finaltext, my_font, fore_color, back_color);

			SDL_RenderClear(renderer1);
			SDL_Rect rect = { 0,0, 800, 100 };
			SDL_RenderCopy(renderer1, textTexture, NULL, &rect);
			SDL_RenderPresent(renderer1);
			while (!quit) {
				while (SDL_PollEvent(&event)) {
					if (event.type == SDL_QUIT)
						quit = true;
				}

			}
			SDL_DestroyRenderer(renderer1);
			SDL_DestroyWindow(window1);
			SDL_DestroyTexture(textTexture);
		}
		SDL_DestroyRenderer(renderer);
	}
else if (numberplayer == 2)
	{
	int flag1,flag2;
	flag1 = chooseskin(poke, renderer2, textTexture, my_font, fore_color, back_color, event, window2);
	flag2 = chooseskin(poke, renderer2, textTexture, my_font, fore_color, back_color, event, window2);
	SDL_DestroyRenderer(renderer2);
	SDL_DestroyWindow(window2);

	SDL_Window* window = SDL_CreateWindow("Maze",
		SDL_WINDOWPOS_CENTERED, SDL_WINDOWPOS_CENTERED,
		Width, Height, SDL_WINDOW_SHOWN);
	SDL_Renderer* renderer = SDL_CreateRenderer(window, -1, 0);
	SDL_SetRenderDrawColor(renderer, 255, 255, 255, 0);
	SDL_RenderClear(renderer);




	SDL_Surface* exit = IMG_Load("Exit.PNG");
	SDL_Texture* Exit = SDL_CreateTextureFromSurface(renderer, exit);
	SDL_FreeSurface(exit);

	SDL_Rect exitplace = { (N - 1) * map.cell_size,(N - 1) * map.cell_size,map.cell_size ,map.cell_size };
	SDL_Rect exitplace2 = { 0,0,map.cell_size ,map.cell_size };
	
	char nametext[] = "gastly .PNG";
	char nametext2[] = "Haunter .PNG";

	if (flag1 < 3)
	{
		nametext[6] = flag1 + 49;
		SDL_Surface* ghostsur = IMG_Load(nametext);
		ghost.HERO = SDL_CreateTextureFromSurface(renderer, ghostsur);
		SDL_FreeSurface(ghostsur);
	}
	else if (flag1 > 2)
	{
		nametext2[7] = flag1 + 46;
		SDL_Surface* ghostsur = IMG_Load(nametext2);
		ghost.HERO = SDL_CreateTextureFromSurface(renderer, ghostsur);
		SDL_FreeSurface(ghostsur);
	}

	if (flag2 < 3)
	{
		nametext[6] = flag2 + 49;
		SDL_Surface* ghostsur = IMG_Load(nametext);
		ghost2.HERO = SDL_CreateTextureFromSurface(renderer, ghostsur);
		SDL_FreeSurface(ghostsur);
	}
	else if (flag2 > 2)
	{
		nametext2[7] = flag2 + 46;
		SDL_Surface* ghostsur = IMG_Load(nametext2);
		ghost2.HERO = SDL_CreateTextureFromSurface(renderer, ghostsur);
		SDL_FreeSurface(ghostsur);
	}

	SDL_Surface * Gold = IMG_Load("gold.PNG");
	gold.ingot = SDL_CreateTextureFromSurface(renderer, Gold);
	SDL_FreeSurface(Gold);
	gold.points = 15;
	SDL_Surface* Silver = IMG_Load("silver.PNG");
	silver.ingot = SDL_CreateTextureFromSurface(renderer, Silver);
	SDL_FreeSurface(Silver);
	silver.points = 10;

	SDL_Surface* Bronze = IMG_Load("bronze.PNG");
	bronze.ingot = SDL_CreateTextureFromSurface(renderer, Bronze);
	SDL_FreeSurface(Bronze);
	bronze.points = 5;


	gold.place = { (rand() % N * 50) + 10,(rand() % N * 50) + 10,30,30 };
	silver.place = { (rand() % N * 50) + 10, (rand() % N * 50) + 10,30,30 };
	bronze.place = { (rand() % N * 50) + 10, (rand() % N * 50) + 10,30,30 };

	bool check = false;
	bool check2 = false;

	quit = false;

	DrawMap(map, renderer, N);
	InitMaze(&map, renderer, N);
	DrawMaze(map, renderer, N, Exit, exitplace, exitplace2);

	SDL_RenderPresent(renderer);


	while (!quit && (ghost.body.x < Width || ghost2.body.x>0))
	{
		while (SDL_PollEvent(&event)) {
			if (event.type == SDL_QUIT)
				quit = true;
			if (event.type == SDL_KEYDOWN && event.key.keysym.sym == SDLK_w)
			{
				counter--;
				if (ghost.body.y >= 0 && MayIMoveUp(map, ghost, N) == true) {
					ghost.body.y -= ghost.step;
					DrawCreatures(&ghost,&ghost2, renderer, N, gold, silver, bronze, Exit, exitplace,exitplace2);
				}
				else if (MayIMoveDown(map, ghost, N) == true) {
					ghost.body.y += map.cell_size; DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
					Hit(Knock);//sound
				}
				else {
					Hit(Knock);//sound
				}

			}
			if (event.type == SDL_KEYDOWN && event.key.keysym.sym == SDLK_s)
			{
				counter--;
				if (ghost.body.y < SCREEN_HEIGHT && MayIMoveDown(map, ghost, N) == true)
				{
					ghost.body.y += ghost.step;
					DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
				}
				else if (MayIMoveUp(map, ghost, N) == true) {
					ghost.body.y -= map.cell_size; DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
					Hit(Knock);//sound
				}
				else {
					Hit(Knock);//sound
				}
			}

			if (event.type == SDL_KEYDOWN && event.key.keysym.sym == SDLK_a)
			{
				counter--;
				if (ghost.body.x > 0 && MayIMoveLeft(map, ghost, N) == true) {
					ghost.body.x -= ghost.step;
					DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
				}
				else if (MayIMoveRight(map, ghost, N) == true) {
					ghost.body.x += map.cell_size; DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
					Hit(Knock);//sound
				}
				else{
					Hit(Knock);//sound
				}
			}

			if (event.type == SDL_KEYDOWN && event.key.keysym.sym == SDLK_d)
			{
				counter--;
				if (ghost.body.x < SCREEN_WIDTH && MayIMoveRight(map, ghost, N) == true) {
					ghost.body.x += ghost.step;
					DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
				}
				else if (MayIMoveLeft(map, ghost, N) == true) {
					ghost.body.x -= map.cell_size; DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
					Hit(Knock);//sound
				}
				else {
					Hit(Knock);//sound
				}
			}

			if (event.type == SDL_KEYDOWN && event.key.keysym.sym == SDLK_UP)
			{
				counter2--;
				if (ghost2.body.y >= 0 && MayIMoveUp(map, ghost2, N) == true) {
					ghost2.body.y -= ghost.step;
					DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
				}
				else if (MayIMoveDown(map, ghost2, N) == true) {
					ghost2.body.y += map.cell_size; DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
					Hit(Knock);//sound
				}
				else {
					Hit(Knock);//sound
				}

			}
			if (event.type == SDL_KEYDOWN && event.key.keysym.sym == SDLK_DOWN)
			{
				counter2--;
				if (ghost2.body.y < SCREEN_HEIGHT && MayIMoveDown(map, ghost2, N) == true)
				{
					ghost2.body.y += ghost.step;
					DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
				}
				else if (MayIMoveUp(map, ghost2, N) == true) {
					ghost2.body.y -= map.cell_size; DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
					Hit(Knock);//sound
				}
				else {
					Hit(Knock);//sound
				}
			}

			if (event.type == SDL_KEYDOWN && event.key.keysym.sym == SDLK_LEFT)
			{
				counter2--;
				if (ghost2.body.x > 0 && MayIMoveLeft(map, ghost2, N) == true) {
					ghost2.body.x -= ghost.step;
					DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
				}
				else if (MayIMoveRight(map, ghost2, N) == true) {
					ghost2.body.x += map.cell_size; DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
					Hit(Knock);//sound
				}
				else {
					Hit(Knock);//sound
				}
			}


			if (event.type == SDL_KEYDOWN && event.key.keysym.sym == SDLK_RIGHT)
			{
				counter2--;
				
				if (ghost2.body.x < SCREEN_WIDTH && MayIMoveRight(map, ghost2, N) == true) {
					ghost2.body.x += ghost.step;
					DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
				}
				else if (MayIMoveLeft(map, ghost2, N) == true) {
					ghost2.body.x -= map.cell_size; DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);
					Hit(Knock);//sound
				} 
				else{
					Hit(Knock);//sound
				}
			}

			if (IsBonusReached(&ghost, gold, silver, bronze) == 1 && gold.taken == false)
			{
				PickBonus(Bonus);
				SDL_DestroyTexture(gold.ingot);
				ghost.points += gold.points;
				gold.taken = true;
			}
			else if (IsBonusReached(&ghost, gold, silver, bronze) == 2 && silver.taken == false)
			{
				PickBonus(Bonus);
				SDL_DestroyTexture(silver.ingot);
				ghost.points += silver.points;
				silver.taken = true;
			}
			else if (IsBonusReached(&ghost, gold, silver, bronze) == 3 && bronze.taken == false)
			{
				PickBonus(Bonus);
				SDL_DestroyTexture(bronze.ingot);
				ghost.points += bronze.points;
				bronze.taken = true;
			}
			if (ghost.body.x >= Width && check == false)
			{
				ghost.points += 50; check = true;
				flag = true;
			}

			if (IsBonusReached(&ghost2, gold, silver, bronze) == 1 && gold.taken == false)
			{
				PickBonus(Bonus);
				SDL_DestroyTexture(gold.ingot);
				ghost2.points += gold.points;
				gold.taken = true;
			}
			else if (IsBonusReached(&ghost2, gold, silver, bronze) == 2 && silver.taken == false)
			{
				PickBonus(Bonus);
				SDL_DestroyTexture(silver.ingot);
				ghost2.points += silver.points;
				silver.taken = true;
			}
			else if (IsBonusReached(&ghost2, gold, silver, bronze) == 3 && bronze.taken == false)
			{
				PickBonus(Bonus);
				SDL_DestroyTexture(bronze.ingot);
				ghost2.points += bronze.points;
				bronze.taken = true;
			}
			if (ghost2.body.x <=0 && check2 == false)
			{
				ghost2.points += 50; check2 = true;
				flag2 = true;
			}

		}



		DrawCreatures(&ghost, &ghost2, renderer, N, gold, silver, bronze, Exit, exitplace, exitplace2);

		SDL_RenderPresent(renderer);
	}
	if (flag == true &&flag2==true) // окно результата
	{
		Final(FinalScore);
		ghost.points += counter;
		ghost2.points += counter2;
		SDL_DestroyWindow(window);
		SDL_Window* window1 = SDL_CreateWindow("Total", SDL_WINDOWPOS_CENTERED, SDL_WINDOWPOS_CENTERED, 800, 220, SDL_WINDOW_SHOWN);
		SDL_Renderer* renderer1 = SDL_CreateRenderer(window1, -1, 0);
		SDL_SetRenderDrawColor(renderer, 255, 255, 255, 0);

		int i = 0;
		char finaltext1[] = "Total score player 1:         ";
		char finaltext2[] = "Total score player 2:         ";
		char temptext[5];
		_itoa_s(ghost.points, temptext, 10);
		while (temptext[i] != '\0')
		{
			finaltext1[i + 23] = temptext[i];
			i++;
		}
		//memset(temptext, ' ', 5);
		i = 0;
		_itoa_s(ghost2.points, temptext, 10);
		while (temptext[i] != '\0')
		{
			finaltext2[i + 23] = temptext[i];
			i++;
		}
		SDL_Texture* textTexture2;
		textTexture = get_text_texture(renderer1, finaltext1, my_font, fore_color, back_color);
		textTexture2 = get_text_texture(renderer1, finaltext2, my_font, fore_color, back_color);
		SDL_RenderClear(renderer1);
		SDL_Rect rect = { 0,0, 800, 100 };
		SDL_RenderCopy(renderer1, textTexture, NULL, &rect);
		SDL_Rect rect2 = { 0,120, 800, 100 };
		SDL_RenderCopy(renderer1, textTexture2, NULL, &rect2);
		SDL_RenderPresent(renderer1);
		while (!quit) {
			while (SDL_PollEvent(&event)) {
				if (event.type == SDL_QUIT)
					quit = true;
			}

		}
		SDL_DestroyRenderer(renderer1);
		SDL_DestroyWindow(window1);
		SDL_DestroyTexture(textTexture);
		SDL_DestroyTexture(textTexture2);
	}
	SDL_DestroyRenderer(renderer);
	}

	TTF_CloseFont(my_font);
	TTF_Quit();
	SDL_Quit();

	
}