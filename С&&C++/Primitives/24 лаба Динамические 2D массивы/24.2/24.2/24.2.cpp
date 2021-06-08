#define _CRT_SECURE_NO_WARNINGS
#include <iostream>


void main()
{
	int** a;

	int i, j, n, * m,A,B,k,flag;

	system("chcp 1251");

	system("cls");

	printf("Enter number of lines: ");

	scanf("%d", &n);

	a = (int**)malloc(n * sizeof(int*));

	m = (int*)malloc(n * sizeof(int)); // массив кол-ва элеменов в строках массива a

	// Ввод элементов массива

	for (i = 0; i < n; i++)

	{

		printf("Enter number of columns of line %d: ", i);

		scanf("%d", &m[i]);

		a[i] = (int*)malloc(m[i] * sizeof(int));

		for (j = 0; j < m[i]; j++) {

			printf("a[%d][%d]= ", i, j);

			scanf("%d", &a[i][j]);

		}

	}

	// Вывод элементов массива

	for (i = 0; i < n; i++)

	{

		for (j = 0; j < m[i]; j++)

		{

			printf("%3d ", a[i][j]);

		}

		printf("\n");

	}
	printf("Enter an interval A-B: ");
	do {
		scanf("%d%d", &A, &B);
		if (A > B)
			printf("Error.A can't be more than B.Try again.\n");
	} while (A > B);

	for (i = 0; i < n; i++)

	{

		for (j = 0; j < m[i]; j++)

		{
			do {
				flag = 0;
				if ((a[i][j] >= A) && (a[i][j] <= B))
				{
					
					for (int c = j; c < m[i] - 1; c++)
					{

						a[i][c] = a[i][c + 1];
						
					}
					m[i]--;
					a[i] = (int*)realloc(a[i], m[i] * sizeof(int));
					flag = 1;
					
				}
				
			} while (flag == 1);
		}

		

	}
	for (i = 0; i < n; i++)

	{

		for (j = 0; j < m[i]; j++)

		{

			printf("%3d ", a[i][j]);

		}

		printf("\n");

	}

	// Освобождение памяти

	for (i = 0; i < n; i++)

	{

		free(a[i]);

	}

	free(a);

	free(m);

	getchar();
	getchar();
}

