#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include <time.h>
#define N 3

double ex(int a[][N])
{

	double k = 0, sum = 0;
	for (int i = 0; i < N; i++)
		for (int j = 0; j < N; j++)
		{
			if ((i + j) % 2 == 0)
			{
				sum += a[i][j];
				k++;
			}
		}
	sum = sum/ k;
	return sum;
	
}
void output(int a[][N])
{
	for (int i = 0; i < N; i++)
	{
		for (int j = 0; j < N; j++)
			printf("a[%d;%d]= %d\t", i, j, a[i][j]);
		printf("\n");
	}
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
void key(int a[][N])
{
	for (int i = 0; i < N; i++)
		for (int j = 0; j < N; j++)
		{
			printf(" a[%d;%d]= ", i, j);
			scanf_s("%d", &a[i][j]);
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
			a[i][j] = rand() % (B - A + 1) + A;
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
	
	fprintf(ft, "Среднее арифмитическое элементов равно %lf\n", ex(a));
	fclose(ft);



}

