#define _CRT_SECURE_NO_WARNINGS
#include "SDL.h"
#include <iostream>
#define _USE_MATH_DEFINES
#undef main
#define k 10
#define SCREEN_WIDTH  900
#define  SCREEN_HEIGHT 600
void cos(int p,int A,int B,SDL_Point*points)
{
	
	int i,a, b;
	printf("f(t)=a*cos(t+b)\n"
		"Введите коэффиценты a и b\n");
	scanf("%d%d", &a, &b);
	
	
	int j = 0;
	if (p == 1)
	{
		for (int i = A; i <= B; i++)
		{
			points[j].x = a*cos((i + b))*k+SCREEN_WIDTH / 2;
			j++;
		}

	}
	else
	{
		for (int i = A; i <= B; i++)
		{
			
			points[j].y = -a*cos((i + b)*M_PI / 180)*k + SCREEN_HEIGHT / 2;
			j++;
		}
	}

}
void sin(int p, int A, int B, SDL_Point*points)
{
	int i, l, u, a, b;
	printf("f(t)=a*sin(t+b)\n"
	"Введите коэффиценты a и b\n");
	scanf("%d%d",&a,&b);
	
	int j = 0;
	if (p == 1)
	{
		for (int i = A; i <= B; i++)
		{
	
			points[j].x = a*sin((i + b))*k + SCREEN_WIDTH / 2;
			j++;
		}

	}
	else
	{
		for (int i = A; i <= B; i++)
		{
		
			points[j].y = -a*sin((i + b)*M_PI / 180)*k + SCREEN_HEIGHT / 2;
			j++;
		}
	}
}
void tg(int p, int A, int B, SDL_Point*points)
{
	int i, l, u, a, b;
	printf("f(t)=a*tg(t+b)\n"
		"Введите коэффиценты a и b\n");
	scanf("%d%d", &a, &b);
	
	
	int j = 0;
	if (p == 1)
	{
		for (int i = A; i <= B; i++)
		{
			
			points[j].x = a * tan((i + b)*M_PI / 180)*k + SCREEN_WIDTH / 2;
			j++;
		}

	}
	else
	{
		for (int i = A; i <= B; i++)
		{
			
			points[j].y = -a * tan((i + b)*M_PI / 180)*k + SCREEN_HEIGHT / 2;
			j++;
		}
	}
}
void ctg(int p, int A, int B, SDL_Point*points)
{
	int i, l, u, a, b;
	printf("f(t)=a*ctg(t+b)\n"
		"Введите коэффиценты a и b\n");
	scanf("%d%d", &a, &b);
	
	int j = 0;
	if (p == 1)
	{
		for (int i = A; i <= B; i++)
		{
			
			points[j].x = a * 1/tan((i + b)*M_PI / 180)*k + SCREEN_WIDTH / 2;
			j++;
		}

	}
	else
	{
		for (int i = A; i <= B; i++)
		{
			
			points[j].y = -a * 1/tan((i + b)*M_PI / 180)*k + SCREEN_HEIGHT / 2;
			j++;
		}
	}
}
void st(int p, int A, int B, SDL_Point*points)
{
	double n;
	printf("f(t)=t^n\n");
	printf("Введите коэффицент n\n");
	scanf("%lf", &n);

	int j = 0;
	if (p == 1)
	{
		for (int i = A; i <= B; i++)
		{
			
				points[j].x = pow(i,n)*k + SCREEN_WIDTH / 2;
				
				j++;
			
		}

	}
	else
	{
		for (int i = A; i <= B; i++)
		{
			points[j].y = -pow(i,n)*k + SCREEN_HEIGHT / 2;
			j++;
		}
	}
	
}
void revst(int p, int A, int B, SDL_Point*points)
{
	double n;
	printf("f(t)=n^t\n");
	printf("Введите коэффицент n\n");
	scanf("%lf", &n);

	int j = 0;
	if (p == 1)
	{
		for (int i = A; i <= B; i++)
		{

			points[j].x = pow(n, i)*k + SCREEN_WIDTH / 2;

			j++;

		}

	}
	else
	{
		for (int i = A; i <= B; i++)
		{
			points[j].y = -pow(n, i)*k + SCREEN_HEIGHT / 2;
			j++;
		}
	}
}
void log(int p, int A, int B, SDL_Point*points)
{
	double n;
	printf("f(t)=log n (t)\n");
	printf("Введите коэффицент n \n");
	do
	scanf("%lf", &n);
	while ((n > 0)&&(n==1));
	int j = 0;
	if (p == 1)
	{
		for (int i = A; i <= B; i++)
		{

			points[j].x = log(i)/log(n)*k + SCREEN_WIDTH / 2;

			j++;

		}

	}
	else
	{
		for (int i = A; i <= B; i++)
		{
			points[j].y = -(log(i) / log(n))*k + SCREEN_HEIGHT / 2;
			j++;
		}
	}
}
void ln(int p, int A, int B, SDL_Point*points)
{
	double n;
	printf("f(t)=ln (t)\n");
	printf("Введите коэффицент n \n");
	do
		scanf("%lf", &n);
	while (n > 0 );
	int j = 0;
	if (p == 1)
	{
		for (int i = A; i <= B; i++)
		{
			
			points[j].x = log(i) *k + SCREEN_WIDTH / 2;

			j++;

		}

	}
	else
	{
		for (int i = A; i <= B; i++)
		{
			points[j].y = -(log(i) / log(n))*k + SCREEN_HEIGHT / 2;
			j++;
		}
	}
}
int main(int argc, char** argv)
{
	int xm, ym, p = 0, A, B,q;
	SDL_Point points [700];
	M_PI;
	setlocale(LC_ALL, "rus");
	
	printf("Выберите как задать x:\n"
	    "1.Cos t\n"
	    "2.Sin t\n"
		"3.Tg t\n"
		"4.Ctg t\n"
		"5.t^n\n"
		"6.n^t\n"
		"7.log n (t)\n"
		"8.ln(t)\n"
	);
	do
	scanf("%d",&xm);
	while (xm<1||xm>7);
	printf("Выберите как задать y:\n"
		"1.Cos t\n"
		"2.Sin t\n"
		"3.Tg t\n"
		"4.Ctg t\n"
		"5.t^n\n"
		"6.n^t\n"
		"7.log n (t)\n"
		"8.ln(t)\n"
	);
	do
	scanf("%d", &ym);
	while (ym < 1 || ym>7);
	printf("Введите промежуток изменения t ");
	do {
		q = 0;
		scanf("%d%d", &A, &B);
		if ((ym == 7 || ym == 8 || xm == 7 || xm == 8) && (A <= 0 || B <= 0))
		{
			printf("Аргумент логарифма должен быть больше нуля.Введите другие значения \n");
			q = 1;
		} 
	} while (A > B || q == 1);
	switch (xm)
	{
	case 1:p = 1; cos(p,A,B,points); break;
	case 2:p = 1; sin(p, A, B, points); break;
	case 3:p = 1; tg(p, A, B, points); break;
	case 4:p = 1; ctg(p, A, B, points); break;
	case 5:p = 1; st(p, A, B, points); break;
	case 6:p = 1; revst(p, A, B, points); break;
	case 7:p = 1; log(p, A, B, points); break;
	case 8:p = 1; ln(p, A, B, points); break;
	}
	switch (ym)
	{
	case 1:p = 0; cos(p, A, B, points); break;
	case 2:p = 0; sin(p, A, B, points); break;
	case 3:p = 0; tg(p, A, B, points); break;
	case 4:p = 0; ctg(p, A, B, points); break;
	case 5:p = 0; st(p, A, B, points); break;
	case 6:p = 0; revst(p, A, B, points); break;
	case 7:p = 0; log(p, A, B, points); break;
	case 8:p = 0; ln(p, A, B, points); break;
	}
	SDL_Init(SDL_INIT_EVERYTHING);
	SDL_Window* window = SDL_CreateWindow(u8"Window",
		100, 100,
		SCREEN_WIDTH, SCREEN_HEIGHT, SDL_WINDOW_SHOWN);
	SDL_Renderer* renderer = SDL_CreateRenderer(window, -1, 0);
	SDL_SetRenderDrawColor(renderer, 0, 0, 0, 0);
	SDL_RenderClear(renderer);
	// оси
	SDL_SetRenderDrawColor(renderer, 255, 255, 255, 0);
	SDL_RenderDrawLine(renderer, SCREEN_WIDTH / 2, 0, SCREEN_WIDTH / 2, SCREEN_HEIGHT);
	SDL_RenderDrawLine(renderer, 0, SCREEN_HEIGHT / 2, SCREEN_WIDTH, SCREEN_HEIGHT / 2);
	//стрелки
	SDL_RenderDrawLine(renderer, SCREEN_WIDTH, SCREEN_HEIGHT / 2, SCREEN_WIDTH - k, (SCREEN_HEIGHT / 2) - k);
	SDL_RenderDrawLine(renderer, SCREEN_WIDTH, SCREEN_HEIGHT / 2, SCREEN_WIDTH - k, (SCREEN_HEIGHT / 2) + k);

	SDL_RenderDrawLine(renderer, SCREEN_WIDTH / 2, 0, (SCREEN_WIDTH / 2) + k, k);
	SDL_RenderDrawLine(renderer, SCREEN_WIDTH / 2, 0, (SCREEN_WIDTH / 2) - k, k);
	// 10 пикселей ед.отрезок
	SDL_RenderDrawLine(renderer, (SCREEN_WIDTH / 2) + k, (SCREEN_HEIGHT / 2) + k / 2, (SCREEN_WIDTH / 2) + k, (SCREEN_HEIGHT / 2) - k / 2);
	SDL_RenderDrawLine(renderer, (SCREEN_WIDTH / 2) - k, (SCREEN_HEIGHT / 2) + k / 2, (SCREEN_WIDTH / 2) - k, (SCREEN_HEIGHT / 2) - k / 2);
	SDL_RenderDrawLine(renderer, (SCREEN_WIDTH / 2) - k / 2, (SCREEN_HEIGHT / 2) - k, (SCREEN_WIDTH / 2) + k / 2, (SCREEN_HEIGHT / 2) - k);
	SDL_RenderDrawLine(renderer, (SCREEN_WIDTH / 2) + k / 2, (SCREEN_HEIGHT / 2) + k, (SCREEN_WIDTH / 2) - k / 2, (SCREEN_HEIGHT / 2) + k);

	// x
	SDL_RenderDrawLine(renderer, SCREEN_WIDTH - 2 * k, SCREEN_HEIGHT / 2 + 2 * k, SCREEN_WIDTH - k, SCREEN_HEIGHT / 2 + 4 * k);
	SDL_RenderDrawLine(renderer, SCREEN_WIDTH - 2 * k, SCREEN_HEIGHT / 2 + 4 * k, SCREEN_WIDTH - k, SCREEN_HEIGHT / 2 + 2 * k);
	//y
	SDL_RenderDrawLine(renderer, SCREEN_WIDTH / 2 + 2 * k, 0, SCREEN_WIDTH / 2 + 2 * k + k / 2, k);
	SDL_RenderDrawLine(renderer, SCREEN_WIDTH / 2 + 3 * k, 0, SCREEN_WIDTH / 2 + 2 * k, 2 * k);
	SDL_RenderDrawLines(renderer, points, B - A);
	SDL_RenderPresent(renderer);
	SDL_Delay(10000);

	SDL_DestroyRenderer(renderer);
	SDL_DestroyWindow(window);
	SDL_Quit();
	return 0;
}
