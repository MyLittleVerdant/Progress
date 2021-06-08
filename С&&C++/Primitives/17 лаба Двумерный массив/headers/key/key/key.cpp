#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include <time.h>
#define N 4
void key(int a[][N])
{
	for (int i = 0; i < N; i++)
		for (int j = 0; j < N; j++)
		{
			printf(" a[%d;%d]= ", i, j);
			scanf_s("%d", &a[i][j]);
		}


}
