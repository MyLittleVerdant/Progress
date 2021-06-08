#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include <time.h>
#define N 4
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
	fprintf(ft, "Среднее арифмитическое элементов равно %d\n", ex(a));
	fclose(ft);



}
