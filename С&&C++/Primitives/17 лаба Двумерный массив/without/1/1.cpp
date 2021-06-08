#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include <time.h>
#define N 4
void output(int a[][N])
{
	for (int i = 0; i < N; i++)
	{
		for (int j = 0; j < N; j++)
			printf("a[%d;%d]= %d\t", i, j, a[i][j]);
		printf("\n");
	}
}
int ex(int a[][N])
{
	double k=0,sum = 0;
	for (int i = 0; i < N; i++)
		for (int j = 0; j < N; j++)
		{
			if ((i + j) % 2 == 0)
			{
				sum += a[i][j];
				k++;
			}
		}
	sum = sum / k;
	return sum;
}
void key(int a[][N])
{
	for (int i = 0; i < N; i++)
		for (int j = 0; j < N; j++)
		{
			printf(" a[%d;%d]= ", i, j);
			scanf_s("%d",&a[i][j]);
		}
	

}
void rand(int a[][N])
{
	int A, B;
	srand(time(NULL));
	do 
	{
		printf("Введите промежуток [a,b] ");
		scanf_s("%d%d", &A, &B);
	} while (A > B);
	for (int i = 0; i < N; i++)
		for (int j = 0; j < N; j++)
			a[i][j] = rand() % (B - A + 1) +A;
	output(a);
			
		
}
void txt(int a[][N])
{
	FILE*f;
	f = fopen("1.txt", "rt");
	for (int i = 0; i < N; i++)
		for (int j = 0; j < N; j++)
		fscanf_s(f, "%d", &a[i][j]);
	fclose(f);
}
void form(int a[][N])
{
	for (int i = 0; i < N; i++)
		for (int j = 0; j < N; j++)
		{
			if (i == 0 && j == 0)
				a[i][j] = 0;
			else if (i > j)
				a[i][j] = i + j;
			else if (i == j)
				a[i][j] = i * 1.0 / j;
			else a[i][j] = i - j;

		}
}
void wtxt(int a[][N])
{
	FILE*ft;
	ft = fopen("2.txt", "w");
	for (int i = 0; i < N; i++)
	{
		for (int j = 0; j < N; j++)
			fprintf(ft, "a[%d;%d]= %d\t", i, j, a[i][j]);
		fprintf(ft, "\n");
	}
	fprintf(ft, "Среднее арифмитическое элементов равно %d\n",ex(a));
	fclose(ft);
	


}

void main()
{
	setlocale(LC_ALL, "rus");
	int a[N][N],m,b;
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
	case 1:output(a); printf("Среднее арифмитическое элементов равно %d\n", ex(a)); break;
	case 2:output(a); ex(a); wtxt(a); break;
	}


	system("pause");


}