#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include <time.h>
#define N 3
#include "massive.h"


void main()
{
	setlocale(LC_ALL, "rus");
	int a[N][N], m, b;
	do {
		printf("Как ввести массив?\n"
			"C клавиатуры-1\n"
			"Случайными числами из промежутка [a,b]-2 \n"
			"Из текстового фаила-3\n"
			"По заданной формуле согласно варианту-4\n"
		);
		scanf_s("%d", &m);
	} while (m < 1 || m>4);
	switch (m)
	{
	case 1: key(a); break;
	case 2: rand(a); break;
	case 3: txt(a); break;
	case 4: form(a); break;
	}
	do {
		printf("Куда вывести результат?\n"
			"На экран-1\n"
			"В текстовый фаил-2\n"

		);
		scanf_s("%d", &b);
	} while (b < 1 || b >2);
	switch (b)
	{
	case 1:output(a); printf("Среднее арифмитическое элементов равно %lf\n", ex(a)); break;
	case 2:output(a); printf("Среднее арифмитическое элементов равно %lf\n", ex(a)); wtxt(a); break;
	}


	system("pause");


}