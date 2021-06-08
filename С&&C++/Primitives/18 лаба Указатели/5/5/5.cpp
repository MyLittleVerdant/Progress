#include<iostream>
void main()
{
	int x, *p;
	x = 10;
	for (int i = 1; i <= x; i++)
	{
		p = &i;
		
			printf_s("%d", *p);
	}
	getchar();
}