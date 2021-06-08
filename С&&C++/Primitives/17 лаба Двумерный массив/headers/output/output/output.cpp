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
