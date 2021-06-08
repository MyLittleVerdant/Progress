#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include <time.h>
#define N 4
int ex(int a[][N])
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
	sum = sum / k;
	return sum;
}
