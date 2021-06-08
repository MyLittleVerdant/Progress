#define _CRT_SECURE_NO_WARNINGS
#include <iostream>

using namespace std;
class Polynom
{
	int n; double x; int* coeff;
public:
	friend class Vector;
	

	Polynom()
	{}
	Polynom(int n,int coeff[], double x)
	{
		this->n = n;
		this->x = x;
		this->coeff = new int[n];
		for (int i = 0; i < n; i++)
			this->coeff[i] = coeff[i];
	}
	Polynom(const Polynom& other)
	{
		this->n = other.n;
		this->x = other.x;
		this->coeff = new int[n];
		for (int i = 0; i < n; i++)
			this->coeff[i] = other.coeff[i];
	}
	Polynom(int n,  int coeff[])
	{
		this->n = n;
		
		this->coeff = new int[n];
		for (int i = 0; i < n; i++)
			this->coeff[i] = coeff[i];
	}

	Polynom operator +(const Polynom&other)
	{
		

		if (this->n >= other.n) { //если степень первого полинома больше степени второго
			Polynom result(n, coeff);
			for (int i = 0; i < other.n; i++)
				result.coeff[i] = result.coeff[i] + other.coeff[i];
			return result;
		}
		else {                   //если степень второго полинома больше степень первого
			Polynom result(other.n, other.coeff);
			for (int i = 0; i < n; i++)
				result.coeff[i] = result.coeff[i] + coeff[i];
			return result;
		}
		
		
	}
	Polynom operator-(const Polynom& other)
	{
		if (this->n >= other.n)
		{
			Polynom result(n, coeff);
			for (int i = 0; i < other.n; i++)
				result.coeff[i] = result.coeff[i] - other.coeff[i];
			return result;
		}
		else {                   //если степень второго полинома больше степень первого
			Polynom result(other.n, other.coeff);
			for (int i = n ; i >= 0; i--)
			{
				if (i > this->n - 1)
					result.coeff[i] *= -1;
				else
					result.coeff[i] = coeff[i]-result.coeff[i] ;
			}
				
			return result;
		}


	}
	double deg(double x, int n)
	{
		double res;
		if (n == 0)
			return 1;
		res = x;
		for (int i = 1; i < n; i++)
		{
			res = res * x;
		}
		return res;
	}
	double Calc()
	{
		double res = 0;
		for (int i = 0; i < n ; i++)
		{
			res = res +coeff[i] *deg(x, i);
		}
		return res;
	}
/*	double Calc()
	{
			return Calculation(x, coeff, 0, n - 1);
	}
	double Calculation(double  x, int a[], int i, int n)
	{
		if (i + 1 < n)
		{
			int temp= Calculation(x, coeff, i + 1, n) * x + coeff[i];
			return temp;
		}
		else
		{
			int temp = coeff[i] * x + coeff[i];
			return coeff[i] * x + coeff[i];
		}
			
	}*/

	void OutputPolynom() {
		

		for (int i = n - 1; i > 0; i--) {
			if (coeff[i] > 0) {
				if(i==n-1&&i!=1)
				{
					if (coeff[i] == 1)
						cout <<  "X^" << i;
					else
						cout << coeff[i] << "X^" << i;
				}
				else if (i == n - 1 && i == 1)
				{
					if (coeff[i] == 1)
						cout << "X" ;
					else
						cout << coeff[i] << "X" ;
				}
				else if (i == 1)
				{
					if (coeff[i] == 1)
						cout << " + " << "X";
					else
						cout << " + " << coeff[i] << "X";
				}
				else
				{
					if (coeff[i] == 1)
						cout << " + " << "X^" << i;
					else
						cout << " + " << coeff[i] << "X^" << i;
				}
			}
			else if (coeff[i] < 0)
				if (coeff[i] == -1)
					cout << " - " << "X^" << i;
				else
					cout << " - " << (-1) * coeff[i] << "X^" << i;
		}

		if (coeff[0] > 0)
			cout << " + " << coeff[0] << "\n";
		else if (coeff[0] < 0)
			cout << " - " << (-1) * coeff[0] << "\n";
	}

};

class Vector
{
	static int count;
	Polynom* arr;
public:
	friend class Polynom;
	friend ostream& operator<< (ostream& out, const Vector& vec);
	Vector()
	{

	}
	Vector(const Vector& other)
	{
		this->Vector::count = other.count;
		this->arr = new Polynom[Vector::count];
		for (int i = 0; i < Vector::count; i++)
		{
			this->arr[i].n = other.arr[i].n;
			this->arr[i].coeff = new int[this->arr[i].n];
			for (int j = 0; j < this->arr[i].n; j++)
			{
				this->arr[i].coeff[j] = other.arr[i].coeff[j];
			}
		}
			
	}
	Vector(Vector vect,Vector vect2)
	{
		arr = new Polynom[Vector::count];
		for (int i = 0; i < Vector::count; i++)
		{
			if (vect.arr[i].n > vect2.arr[i].n)
			{
				arr[i].n = vect.arr[i].n;
				arr[i].coeff = new int[arr[i].n];

			}
			else 
			{ 
				arr[i].n = vect2.arr[i].n;
				arr[i].coeff = new int[arr[i].n]; 
			}
			for (int j = 0; j < this->arr[i].n; j++)
			{
				this->arr[i].coeff[j] = 0;
			}


		}
	}
	Vector(int count)
	{
		Vector::count = count;
		arr = new Polynom[count];
		for (int i = 0; i < count; i++)
		{
			
			do {
				cout << "Enter number of coefficients: ";
				cin >> arr[i].n;
				
			} while (arr[i].n < 1);
			arr[i].coeff = new int[arr[i].n];
			
			cout << "Enter coefficients: " << endl;
			for (int j = 0; j < arr[i].n; j++)
			{
				cin >> arr[i].coeff[j];
			}
			

		}
	}
	~Vector()
	{
		delete[] arr;
	}
	


	Polynom sum(int m,int v)
	{
		
		if (this->arr[m].n >= arr[v].n) { //если степень первого полинома больше степени второго
			Polynom result(arr[m].n, arr[m].coeff);
			for (int i = 0; i < arr[v].n; i++)
				result.coeff[i] = result.coeff[i] + arr[v].coeff[i];
			return result;
		}
		else {                   //если степень второго полинома больше степень первого
			Polynom result(arr[v].n, arr[v].coeff);
			for (int i = 0; i < arr[m].n; i++)
				result.coeff[i] = result.coeff[i] + arr[m].coeff[i];
			return result;
		}


	}
	Vector operator +(const Vector& other)
	{
		Vector temp;
		temp.arr = new Polynom[Vector::count];
		for (int i = 0; i < Vector::count; i++)
		{
			
			if (this->arr[i].n > other.arr[i].n)
			
				temp.arr[i].coeff = new int[this->arr[i].n];
			
				else temp.arr[i].coeff = new int[other.arr[i].n];

			temp.arr[i] = this->arr[i] + other.arr[i];
		}
		return temp;
	}
	void Vsum(Vector v1, Vector v2)
	{
		for (int i = 0; i < Vector::count; i++)
		{
			Polynom res= v1.arr[i] + v2.arr[i];
			res.OutputPolynom();
			cout << endl;
		}
		
	}
	Polynom sub(int m, int v)
	{
		

			if (this->arr[m].n >= arr[v].n) { //если степень первого полинома больше степени второго
				Polynom result(arr[m].n, arr[m].coeff);
				for (int i = 0; i < arr[v].n; i++)
					result.coeff[i] = result.coeff[i] - arr[v].coeff[i];
				return result;
			}
			else {                   //если степень второго полинома больше степень первого
				Polynom result(arr[v].n, arr[v].coeff);
				for (int i = arr[v].n-1; i >= 0; i--)
				{
					if (i > arr[m].n-1)
						result.coeff[i] *= -1;
					else
					result.coeff[i] = result.coeff[i] - arr[m].coeff[i];
				}
					
				return result;
			}


	}
	Vector operator -(const Vector& other)
	{
		Vector temp;
		for (int i = 0; i < Vector::count; i++)
		{
			temp.arr = new Polynom[Vector::count];
			if (this->arr[i].n > other.arr[i].n)
				temp.arr[i].coeff = new int[this->arr[i].n];
			else temp.arr[i].coeff = new int[other.arr[i].n];
			temp.arr[i] = arr[i] - other.arr[i];
		}
		return temp;
	}

	void Vsub(Vector v1, Vector v2)
	{
		for (int i = 0; i < Vector::count; i++)
		{
			Polynom res = v1.arr[i] - v2.arr[i];
			res.OutputPolynom();
			cout << endl;
		}
	}
	void VOutputPolynom(const Polynom m) {


		for (int i = m.n - 1; i > 0; i--) {
			if (m.coeff[i] > 0) {
				if (i == m.n - 1 && i != 1)
				{
					if (m.coeff[i] == 1)
						cout << "X^" << i;
					else
						cout << m.coeff[i] << "X^" << i;
				}
				else if (i == m.n - 1 && i == 1)
				{
					if (m.coeff[i] == 1)
						cout << "X";
					else
						cout << m.coeff[i] << "X";
				}
				else if (i == 1)
				{
					if (m.coeff[i] == 1)
						cout << " + " << "X";
					else
						cout << " + " << m.coeff[i] << "X";
				}
				else
				{
					if (m.coeff[i] == 1)
						cout << " + " << "X^" << i;
					else
						cout << " + " << m.coeff[i] << "X^" << i;
				}
			}
			else if (m.coeff[i] < 0)
				if (m.coeff[i] == -1)
					cout << " - " << "X^" << i;
				else
					cout << " - " << (-1) * m.coeff[i] << "X^" << i;
		}

		if (m.coeff[0] > 0)
			cout << " + " << m.coeff[0] << "\n";
		else if (m.coeff[0] < 0)
			cout << " - " << (-1) * m.coeff[0] << "\n";
	}

	void VectOut()
	{
		for (int i = 0; i <Vector::count; i++)
		{
			VOutputPolynom(arr[i]);
			cout << endl;
		}
	}

};

int Vector::count;


void main()
{
	double temp;
	int c,num,num1,Vectsize;
	
	int a[] = { 1,2,3 };
	int b[] = { 5,7 };

	Polynom od(3, a);
	od.OutputPolynom();
	cout << endl;

	Polynom dv(2, b);
	dv.OutputPolynom();
	cout << endl;

	Polynom tr = od + dv;
	tr.OutputPolynom();
	cout << endl;

	tr =dv-tr;
	tr.OutputPolynom();
	cout << endl;

	

	Polynom ch(3, a, 5);
	cout<< ch.Calc()<<endl<<endl;
	do {
		cout << "Enter the size of vectors: ";
		cin >> Vectsize;
	} while (Vectsize < 0);

	Vector vect(Vectsize);
	Vector vect2(Vectsize);
	Vector res(vect, vect2);
	do {
		cout << "1.Sum " << endl<<"2.Sub "<<endl;
		cin >> c;
		switch (c)
		{
		case 1:res.Vsum(vect, vect2);  break;                         // res = vect + vect2;res.VectOut();                         
		case 2:res.Vsub(vect, vect2); break;
		
		}
	} while (c!=5);

}
