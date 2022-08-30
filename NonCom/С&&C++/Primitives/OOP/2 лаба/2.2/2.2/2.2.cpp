#include <iostream>
#include <math.h>
using namespace std;
//sin(x+y) - 1.2x = 0
//x² + y² = 1


class systema
{
private:
	double x, y, e = 0.0001;

public:
	void fill(double x, double y,double e)
	{
		this->x = x;
		this->y = y;
		this->e = e;
	}
	double function1()
	{
		return sin(x + y) - 1.2 * x;
	}

	double function2()
	{
		return x * x + y * y - 1;
	}

	double func11()
	{
		return cos(x + y) - 1.2;
	}

	double func12()
	{
		return cos(x + y);
	}

	double func21()
	{
		return 2 * x;
	}

	double func22()
	{
		return 2 * y;
	}
	void ret_matr(double a[2][2])
	{
		double det, aa;
		det = a[0][0] * a[1][1] - a[0][1] * a[1][0];
		if (det != 0)
		{
			aa = a[0][0];
			a[0][0] = a[1][1] / det;
			a[1][1] = aa / det;

			a[0][1] = -a[0][1] / det;
			a[1][0] = -a[1][0] / det;
		}
		else cout << "";
	}

	void nuton()
	{
		int i = 1;
		double a[2][2], dx, dy, b[2], norm;
		do
		{
			a[0][0] = func11();
			a[0][1] = func12();
			a[1][0] = func21();
			a[1][1] = func22();
			ret_matr(a);
			dx = -a[0][0] * function1() + -a[0][1] * function2();
			dy = -a[1][0] * function1() + -a[1][1] * function2();
			x = x + dx;
			y = y + dy;
			b[0] = function1();
			b[1] = function2();
			norm = sqrt(b[0] * b[0] + b[1] * b[1]);
			i++;
		} while (norm >= e);
		cout << x << endl << y << endl;
	}


};

void main()
{
	systema New;
	double x, y,e;
	cout << "x = ";
	cin >> x;
	cout << "y = ";
	cin >> y;
	do {
		cout << "e = ";
		cin >> e;
	} while (e <=0.0);
	New.fill(x, y, e);
	New.nuton();
	cout << endl;
	
}