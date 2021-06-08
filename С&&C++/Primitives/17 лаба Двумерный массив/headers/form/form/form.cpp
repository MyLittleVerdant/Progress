#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include <time.h>
#define N 4
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
