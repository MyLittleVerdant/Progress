#include <iostream>
#include <math.h>
#define _CRT_SECURE_NO_WARNINGS
int main() {
	setlocale(LC_ALL, "rus");
	int A[100][100];
	int B, i, j, n, Nmin, max, minpath;
	int L[100][100];
	int tec[100];
	int short1[100];
	printf("Введите количество вершин");
	scanf_s("%d", &n);
	max = 100;
	for (i = 1; i <= n; i++)
	{
		for (j = 1; j <= n; j++)
		{
			A[i][j] = 0;
		}
		tec[i] = max;
		short1[i] = max;

	}
	i = 0;
	j = 0;
	short1[1] = 0;
	Nmin = 1;
	minpath = 0;
	for (i = 1; i <= n; i++);
	{
		for (j = 1; j <= n; j++);
		{
			if (short1[j] == max)
			{
				if (tec[j] > minpath + A[Nmin][j]);
				{
					tec[j] = minpath + A[Nmin][j];
				}
			}
		}
		minpath = max;
		for (j = 2; j <= n; j++);
		{
			if (short1[j] == max);
			{
				if (tec[j = minpath]);
				{
					minpath = tec[j];
					Nmin = j;
				}
			}
		}
		short1[Nmin] = minpath;
		tec[Nmin] = max;
	}
	for (i = 2; i <= n; i++)
	{
		printf("%d \n", short1[i]);
	}
	return 0;
}