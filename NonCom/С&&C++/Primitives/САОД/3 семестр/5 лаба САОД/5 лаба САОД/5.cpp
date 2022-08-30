#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
using namespace std;


struct Nodeh
{
	string name;
	string data;
	Nodeh* Next, * Prev;

};



class Hour
{
	int Count = 0;
	Nodeh* Headh, * Tailh;
public:
	friend class Day;
	Hour() :Headh(NULL), Tailh(NULL) {};

	void AddTail(string name,string data)
	{
		// Создаем новый элемент
		Nodeh* temp = new Nodeh;
		// Следующего нет
		temp->Next = 0;
		// Заполняем данные
		temp->data = data;
		temp->name = name;
		// Предыдущий - бывший хвост
		temp->Prev = Tailh;

		// Если элементы есть?
		if (Tailh != 0)
			Tailh->Next = temp;

		// Если элемент первый, то он одновременно и голова и хвост
		if (Count == 0)
			Headh = Tailh = temp;
		else
			// иначе новый элемент - хвостовой
			Tailh = temp;

		Count++;
	}
	Hour(const Hour &other)
	{
		this->Headh = this->Tailh = NULL;
		Nodeh* curnode = other.Headh;
		
		while (curnode)
		{
			
			AddTail(curnode->name, curnode->data);
			curnode = curnode->Next;

		}
	}
	~Hour()
	{
		while (Headh) // До тех пор, пока головной элемент не равен NULL
		{
			Tailh = Headh->Next; // Переопределяем хвост
			delete Headh;// Удаляем голову
			Headh = Tailh;// Определяем новую голову
		}
	}
	Nodeh Add(string h)
	{

		Nodeh* temp = new Nodeh; // Создаем новый элемент.
		temp->Next = temp->Prev = NULL; // Обнуляем его указатель на следующий.
		temp->name = h;
		if (Headh != NULL)
		{
			temp->Prev = Tailh;
			Tailh->Next = temp;
			Tailh = temp;
		}
		else
		{
			temp->Prev = NULL;
			Headh = Tailh = temp;
		}


		return *Headh;
	}
	Nodeh info(string name)
	{
		Nodeh* temp = Headh;
		while (temp != NULL) // Просматриваем весь список.
		{
			if (temp->name == name)
				return *temp;
			else
				temp = temp->Next;
		}
	}
	void putData(Nodeh& h)
	{
		string data;
		cout << "Enter note: ";
		cin >> data;
		if (h.data == "")
			h.data = data;
		else
		{
			h.data += "\n";
			h.data += data;
		}
	}
};


struct Noded
{
	string name;
	Hour hour;
	Noded* Next, * Prev;

};

class Day
{
	int Count = 0;
	Noded* Headd, * Taild;
public:
	friend class Month;
	Day() :Headd(NULL), Taild(NULL) {};
	~Day()
	{
		while (Headd) // До тех пор, пока головной элемент не равен NULL
		{
			Taild = Headd->Next; // Переопределяем хвост
			delete Headd;// Удаляем голову
			Headd = Taild;// Определяем новую голову
		}
	}
	void AddTail(string name)
	{
		// Создаем новый элемент
		Noded* temp = new Noded;
		// Следующего нет
		temp->Next = 0;
		// Заполняем данные
		temp->name = name;
		// Предыдущий - бывший хвост
		temp->Prev = Taild;

		// Если элементы есть?
		if (Taild != 0)
			Taild->Next = temp;

		// Если элемент первый, то он одновременно и голова и хвост
		if (Count == 0)
			Headd = Taild = temp;
		else
			// иначе новый элемент - хвостовой
			Taild = temp;

		Count++;
	}
	Day(const Day & other)
	{
		this->Headd = this->Taild = NULL;
		Noded* curnode = other.Headd;

		while (curnode)
		{

			AddTail(curnode->name);
			curnode = curnode->Next;

		}
	}
	Noded Add(string d)
	{

		Noded* temp = new Noded; // Создаем новый элемент.
		temp->Next = temp->Prev = NULL; // Обнуляем его указатель на следующий.
		temp->name = d;
		if (Headd != NULL)
		{
			temp->Prev = Taild;
			Taild->Next = temp;
			Taild = temp;
		}
		else
		{
			temp->Prev = NULL;
			Headd = Taild = temp;
		}
		return *temp;
	}
	Noded info(string name)
	{
		Noded* temp = Headd;
		while (temp != NULL) // Просматриваем весь список.
		{
			if (temp->name == name)
				return *temp;
			else
				temp = temp->Next;
		}
	}
	void deeper(Noded& d)
	{
		
		string name;
		cout << "Enter hour:";
		cin >> name;
		if (d.hour.Headh == NULL)
		{
			Nodeh temp = d.hour.Add(name);
		
			d.hour.putData(temp);

		}
		else
		{
			Nodeh temp = d.hour.info(name);
			
			d.hour.putData(temp);

		}

	}
	void showH(Noded* d)
	{
		Nodeh* temp = d->hour.Headh;
		while (temp != NULL) // Просматриваем весь список.
		{
			cout << temp->name << ":" << endl;
			cout << temp->data << endl << endl;
			temp = temp->Next;
		}
	}
};




struct Nodem
{
	string name;
	Day day;
	Nodem* Next, * Prev;

};

class Month
{
	int Count = 0;
	Nodem* Headm, * Tailm;
public:
	friend class Year;
	Month() :Headm(NULL), Tailm(NULL) {};
	~Month()
	{
		while (Headm) // До тех пор, пока головной элемент не равен NULL
		{
			Tailm = Headm->Next; // Переопределяем хвост
			delete Headm;// Удаляем голову
			Headm = Tailm;// Определяем новую голову
		}
	}
	void AddTail(string name)
	{
		// Создаем новый элемент
		Nodem* temp = new Nodem;
		// Следующего нет
		temp->Next = 0;
		// Заполняем данные
		temp->name = name;
		// Предыдущий - бывший хвост
		temp->Prev = Tailm;

		// Если элементы есть?
		if (Tailm != 0)
			Tailm->Next = temp;

		// Если элемент первый, то он одновременно и голова и хвост
		if (Count == 0)
			Headm = Tailm = temp;
		else
			// иначе новый элемент - хвостовой
			Tailm = temp;

		Count++;
	}
	Month(const Month& other)
	{
		this->Headm = this->Tailm= NULL;
		Nodem* curnode = other.Headm;

		while (curnode)
		{

			AddTail(curnode->name);
			curnode = curnode->Next;

		}
	}
	Nodem Add(string m)
	{

		Nodem* temp = new Nodem; // Создаем новый элемент.
		temp->Next = temp->Prev = NULL; // Обнуляем его указатель на следующий.
		temp->name = m;
		//	Headm->count++;

		if (Headm != NULL)
		{
			temp->Prev = Tailm;
			Tailm->Next = temp;
			Tailm = temp;
		}
		else
		{
			temp->Prev = NULL;
			Headm = Tailm = temp;
		}

		return *temp;
	}
	Nodem info(string name)
	{
		Nodem* temp = Headm;
		while (temp != NULL) // Просматриваем весь список.
		{
			if (temp->name == name)
				return *temp;
			else
				temp = temp->Next;
		}
	}
	void deeper(Nodem& m)
	{
		
		string name;
		cout << "Enter day:";
		cin >> name;
		if (m.day.Headd == NULL)
		{
			Noded temp = m.day.Add(name);
			  
			m.day.deeper(temp);

		}
		else
		{
			Noded temp = m.day.info(name);
			
			m.day.deeper(temp);
		}

	}
	void showD(Nodem* m)
	{
		Noded* temp = m->day.Headd;
		while (temp != NULL) // Просматриваем весь список.
		{
			cout << temp->name << ":" << endl;
			m->day.showH(temp);
			temp = temp->Next;
		}
	}
};

struct Nodey
{
	string name;
	Month month;
	Nodey* Next, * Prev;

};

class Year
{
	int Count = 0;
	Nodey* Heady, * Taily;
public:
	
	friend class datebook;
	Year() :Heady(NULL), Taily(NULL) {};
	~Year()
	{
		while (Heady) // До тех пор, пока головной элемент не равен NULL
		{
			Taily = Heady->Next; // Переопределяем хвост
			delete Heady;// Удаляем голову
			Heady = Taily;// Определяем новую голову
		}
	}
	void AddTail(string name)
	{
		// Создаем новый элемент
		Nodey* temp = new Nodey;
		// Следующего нет
		temp->Next = 0;
		// Заполняем данные
		temp->name = name;
		// Предыдущий - бывший хвост
		temp->Prev = Taily;

		// Если элементы есть?
		if (Taily != 0)
			Taily->Next = temp;

		// Если элемент первый, то он одновременно и голова и хвост
		if (Count == 0)
			Heady = Taily = temp;
		else
			// иначе новый элемент - хвостовой
			Taily = temp;

		Count++;
	}
	Year(const Year& other)
	{
		this->Heady = this->Taily = NULL;
		Nodey* curnode = other.Heady;

		while (curnode)
		{

			AddTail(curnode->name);
			curnode = curnode->Next;

		}
	}
	Nodey Add(string y)
	{
		Nodey* temp = new Nodey; // Создаем новый элемент.
		temp->Next = temp->Prev = NULL; // Обнуляем его указатель на следующий.
		temp->name = y;
		
		if (Heady != NULL)
		{
			temp->Prev = Taily;
			Taily->Next = temp;
			Taily = temp;
		}
		else
		{
			temp->Prev = NULL;
			Heady = Taily = temp;
		}
		return *temp;
	}
	Nodey info(string name)
	{
		Nodey* temp = Heady;
		while (temp != NULL) // Просматриваем весь список.
		{
			if (temp->name == name)
				return *temp;
			else
				temp = temp->Next;
		}
	}
	void deeper(Nodey &y)
	{
	
		string name;
		cout << "Enter month:";
		cin >> name;
		if (y.month.Headm == NULL)
		{
			Nodem temp = y.month.Add(name);
			
			y.month.deeper(temp);
			
		}
		else
		{
			Nodem temp = y.month.info(name);
			
			y.month.deeper(temp);
		}

	}
	void showM(Nodey *y)
	{
		Nodem* temp = y->month.Headm;
		while (temp != NULL) // Просматриваем весь список.
		{
			cout << temp->name << ":" << endl;
			y->month.showD(temp);
			temp = temp->Next;
		}
	}
};



class datebook
{
	Year year;
	

public:

	void Add()
	{
		
		string name;
		cout << "Enter year:";
		cin >> name;
		if (year.Heady == NULL)
		{
			Nodey temp =year.Add(name);
			
			year.deeper(temp);
		}
		else
		{
			Nodey temp = year.info(name);
			
			year.deeper(temp);
			
		}
	}
	void showAll()
	{
		if (year.Heady == NULL)
			cout << "There are no notes" << endl;
		else
		{
			Nodey* temp = year.Heady;
			while (temp != NULL) // Просматриваем весь список.
			{
				cout << temp->name << ":"<<endl;
				year.showM(temp);
				temp = temp->Next;
			}
		}
	}
	
};


void main()
{
	datebook book;
	book.Add();
	book.Add();
	book.showAll();
}







/*class Hour
{
	Node* Headh, * Tailh;
public:
	friend class Hour;
	Hour() :Headh(NULL), Tailh(NULL) {};
	~Hour()
	{
		while (Headh) // До тех пор, пока головной элемент не равен NULL
		{
			Tailh = Headh->Next; // Переопределяем хвост
			delete Headh;// Удаляем голову
			Headh = Tailh;// Определяем новую голову
		}
	}
	
};

class Day
{
	Node* Headd, * Taild;
public:
	friend class Hour;
	Day() :Headd(NULL), Taild(NULL) {};
	~Day()
	{
		while (Headd) // До тех пор, пока головной элемент не равен NULL
		{
			Taild = Headd->Next; // Переопределяем хвост
			delete Headd;// Удаляем голову
			Headd = Taild;// Определяем новую голову
		}
	}
	

};


class Month
{

	Node* Headm, * Tailm;
public:
	friend class Day;
	friend class Year;
	Month() :Headm(NULL), Tailm(NULL) {};
	~Month()
	{
		while (Headm) // До тех пор, пока головной элемент не равен NULL
		{
			Tailm = Headm->Next; // Переопределяем хвост
			delete Headm;// Удаляем голову
			Headm = Tailm;// Определяем новую голову
		}
	}


	
};



class Year
{
	Node* Heady, * Taily;
public:
	friend class Month;
	Year() :Heady(NULL), Taily(NULL) {};
	~Year()
	{
		while (Heady) // До тех пор, пока головной элемент не равен NULL
		{
			Taily = Heady->Next; // Переопределяем хвост
			delete Heady;// Удаляем голову
			Heady = Taily;// Определяем новую голову
		}
	}
	/*bool check(string y, string m, string d, string h)
	{
		
		Node* temp =Heady;
		while (temp != NULL) // Просматриваем весь список.
		{
			if (y == temp->name)
			{
				temp = Headm;
				while (temp != NULL)
					if(m== temp->name)

			}
			else
			temp = temp->Next;
		}
		return false;
	}
	
	void show(string y, string m, string d, string h)
	{
		Node* temp = Heady;
		
			cout << temp->deep->deep->deep->data;
			temp = temp->Next;
		
	}
	
};





void main()
{
	string y, m, d, h,data;
	Year year;
	Month month;
	Day day;
	Hour hour;
	
	
	
	
	
	year.create(month,day,hour);

	year.show(y, m, d, h);
}*/