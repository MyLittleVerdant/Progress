#include <iostream>
void order(int *a, int *b, int *c)
{
	int f, s, t;
	if (fabs(*a) >= fabs(*b) && fabs(*a) >= fabs(*c))
	{
		f = *a;
		if (fabs(*b) > fabs(*c))
		{
			s = *b; t = *c;
		}
		else {
			s = *c; t = *b;
		}
	}
	if (fabs(*b) >= fabs(*a) && fabs(*b) >= fabs(*c))
	{
		f = *b;
		if (fabs(*a) > fabs(*c))
		{
			s = *a; t = *c;
		}
		else
		{
			s = *c; t = *a;
		}
	}
	if (fabs(*c) >= fabs(*b) && fabs(*c) >= fabs(*a))
	{
		f = *c;
		if (fabs(*b) > fabs(*a))
		{
			s = *b; t = *a;
		}
		else {
			s = *a; t = *b;
		}
	}
	printf_s("%d %d %d\n",t,s,f);
	
}
void main()
{
	int a, b, c;
	scanf_s("%d%d%d", &a, &b, &c);
	order(&a, &b, &c);
	system("pause");
}