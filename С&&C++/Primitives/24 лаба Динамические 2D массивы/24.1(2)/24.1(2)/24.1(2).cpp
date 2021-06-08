#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
#include "Second.h"
void main()
{
	int** a;
	int i, j, n, m, A, B, num = 0, sum = 0;

	printf("Enter number of lines: ");
	do {
		scanf("%d", &n);
		if (n < 2)
			printf("Invalid enter.try again\n");
	} while (n < 2);
	printf("Enter number of columns: ");

	do {
		scanf("%d", &m);
		if (m < 2)
			printf("Invalid enter.try again\n");
	} while (m < 2);

	// Выделение памяти

	a = (int**)malloc(n * sizeof(int*));

	Create(n, m, a);

	// Вывод элементов массива
	Output(n, m, a);
	
	Count(n, m, a, &num, &sum);

	printf("Number of required elements = %d and their sum = %d\n", num, sum);
	for (i = 0; i < n; i++) // цикл по строкам

		free(a[i]); // освобождение памяти под строку

	free(a);

	system("pause");



}
