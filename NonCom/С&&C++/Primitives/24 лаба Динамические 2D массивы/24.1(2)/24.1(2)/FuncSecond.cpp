#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
int** Create(int n, int m, int** a)
{
	// Ввод элементов массива

	for (int i = 0; i < n; i++) // цикл по строкам
	{
		a[i] = (int*)malloc(m * sizeof(int));
		for (int j = 0; j < m; j++) // цикл по столбцам

		{

			printf("a[%d][%d] = ", i, j);

			scanf("%d", &a[i][j]);

		}

	}
	return a;
}
void Output(int n, int m, int** a)
{
	for (int i = 0; i < n; i++) // цикл по строкам

	{

		for (int j = 0; j < m; j++) // цикл по столбцам

		{

			printf("%5d ", a[i][j]); // 5 знакомест под элемент массива

		}

		printf("\n");

	}
}
void Count(int n, int m, int** a, int* k, int* c)
{
	int A, B;
	printf("Enter an interval A-B: ");
	do {
		scanf("%d%d", &A, &B);
		if (A > B)
			printf("Error.A can't be more than B.Try again.\n");
	} while (A > B);

	for (int i = 0; i < n; i++)
	{

		for (int j = 0; j < m; j++)
		{
			if ((a[i][j] < A) || (a[i][j] > B))
			{
				*k += 1;
				*c += a[i][j];
			}
		}
	}
}
