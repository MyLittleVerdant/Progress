#include <iostream>
void main()
{
	setlocale(LC_ALL, "rus");
	int A[10] = { 1,2,3,4,5,6,7,8,9,10 };
	int*p;
	p = A;
	printf_s("%d\n", *p);
	p+=20;
	printf_s("%d\n", *p);
	p = p-1;
	printf_s("%d\n", *p);
	system("pause");
}