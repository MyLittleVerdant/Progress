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

void rand(int a[][N])
{
	int A, B;
	srand(time(NULL));
	do
	{
		printf("¬ведите промежуток [a,b] ");
		scanf_s("%d%d", &A, &B);
	} while (A > B);
	for (int i = 0; i < N; i++)
		for (int j = 0; j < N; j++)
			a[i][j] = rand() % (B - A + 1) + A;
	output(a);


}
