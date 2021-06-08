#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include <time.h>
#define N 4
void txt(int a[][N])
{
	FILE*f;
	f = fopen("1.txt", "rt");
	for (int i = 0; i < N; i++)
		for (int j = 0; j < N; j++)
			fscanf_s(f, "%d", &a[i][j]);
	fclose(f);
}
