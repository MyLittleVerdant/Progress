#include <iostream>
void main()
{
	int x, *p;
	x = 10;
	p = &x;
	printf_s("%d", *p);
	getchar();
}