#define _CRT_SECURE_NO_WARNINGS
#include "first.h"
#include <iostream>

void main()
{
	int* a;
	int  n, m, num = 0, sum = 0;
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
	 a = (int*)malloc(n * m * sizeof(int));
	Create(n, m,a);
	Output(n,m,a);
	Count(n, m, a, &sum, &num);
	
	printf("Number of required elements = %d and their sum = %d\n",num,sum);
	free(a);

	system("pause");



}
