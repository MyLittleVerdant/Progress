#include <iostream>
#include <string>
using namespace std;


class SubList;

class ListH
{
public:
	struct Node
	{

		string t;
		string data;
		Node* Next, * Prev;
		Node(string data,string t) : Next(NULL), data(data),t(t) {}
	};
	
	Node* Head;
	int count;
	ListH() :Head(NULL) {};

	~ListH()
	{
		clear();
	}

	int Add(string t, string data)//Добавление элемента в конец списка. Возвращает количество элементов в списке
	{
		Node* to_add = new Node(data,t);
		if (Head == NULL) //Если в списке нет элементов
			Head = to_add;
		else
		{
			Node* current;
			for (current = Head; current->Next != 0; current = current->Next);
			current->Next = to_add;
		}
		count++;
		return count;
	}

	
	void Show()
	{
		Node* temp = Head;
		while (temp != NULL) // Просматриваем весь список.
		{
			cout << temp->t <<":\t" << temp->data << "\n";
			
			temp = temp->Next;
		}
	}

	void ShowPer(string t)
	{
		Node* temp = Head;
		while (temp != NULL) // Просматриваем весь список.
		{
			if (temp->t == t)
			{
				cout << temp->t << ":\t" << temp->data << "\n\n";
				temp = temp->Next;

			}
			else
				temp = temp->Next;
		}
	}

	void clear() //Очистка списка
	{
		Node* current = Head;
		Node* to_del = Head;
		while (to_del != NULL)
		{
			current = current->Next;
			delete to_del;
			to_del = current;
		}
		Head = NULL;
		count = 0;
	}

};


class ListD
{
public:
	struct Node
	{

		ListH l;
		unsigned int t;
		Node* Next, * Prev;
		Node(unsigned int t) : Next(NULL), t(t) {}
	};
	
	Node* Head;
	int count;
	ListD() :Head(NULL) {};

	~ListD()
	{
		clear();
	}

	int Add(unsigned int t,string hour, string data)//Добавление элемента в конец списка. Возвращает количество элементов в списке
	{
		Node* to_add = new Node(t);
		if (Head == NULL) //Если в списке нет элементов
			Head = to_add;
		else
		{
			Node* current;
			for (current = Head; current->Next != 0; current = current->Next);
			current->Next = to_add;
		}
		count++;
		to_add->l.Add(hour, data);
		return count;
	}


	void Show()
	{
		Node* temp = Head;
		while (temp != NULL) // Просматриваем весь список.
		{
			cout << temp->t << ":\t"<< "\n";
			temp->l.Show();
			temp = temp->Next;
		}
	}

	void ShowPer(string hour, unsigned int t)
	{
		Node* temp = Head;
		while (temp != NULL) // Просматриваем весь список.
		{
			if (temp->t == t)
			{
				cout << temp->t << ":\t" << "\n";
				temp->l.ShowPer(hour);
				temp = temp->Next;

			}
			else
				temp = temp->Next;
		}
	}



	void clear() //Очистка списка
	{
		Node* current = Head;
		Node* to_del = Head;
		while (to_del != NULL)
		{
			current = current->Next;
			delete to_del;
			to_del = current;
		}
		Head = NULL;
		count = 0;
	}


};


class ListM
{
public:
	struct Node
	{

		ListD l;
		string t;
		Node* Next, * Prev;
		Node(string t) : Next(NULL), t(t) {}
	};

	Node* Head;
	int count;
	ListM() :Head(NULL) {};

	~ListM()
	{
		clear();
	}

	int Add(string t,string hour, unsigned int day, string data)//Добавление элемента в конец списка. Возвращает количество элементов в списке
	{
		Node* to_add = new Node(t);
		if (Head == NULL) //Если в списке нет элементов
			Head = to_add;
		else
		{
			Node* current;
			for (current = Head; current->Next != 0; current = current->Next);
			current->Next = to_add;
		}
		count++;
		to_add->l.Add(day, hour, data);
		return count;
	}


	void Show()
	{
		Node* temp = Head;
		while (temp != NULL) // Просматриваем весь список.
		{
			cout << temp->t << ":\t" << "\n";
			temp->l.Show();
			temp = temp->Next;
		}
	}

	void ShowPer(string t, string hour, unsigned int day)
	{
		Node* temp = Head;
		while (temp != NULL) // Просматриваем весь список.
		{
			if (temp->t == t)
			{
				cout << temp->t << ":\t" << "\n";
				temp->l.ShowPer(hour, day);
				temp = temp->Next;

			}
			else
				temp = temp->Next;
		}
	}

	void clear() //Очистка списка
	{
		Node* current = Head;
		Node* to_del = Head;
		while (to_del != NULL)
		{
			current = current->Next;
			delete to_del;
			to_del = current;
		}
		Head = NULL;
		count = 0;
	}


};


class ListY
{
public:
	struct Node
	{

		ListM l;
		unsigned int t;
		Node* Next, * Prev;
		Node(unsigned int t) : Next(NULL), t(t) {}
	};

	Node* Head;
	int count;
	ListY() :Head(NULL) {};

	~ListY()
	{
		clear();
	}

	int Add(unsigned int t, string month, string hour, unsigned int day,string data)//Добавление элемента в конец списка. Возвращает количество элементов в списке
	{
		Node* to_add = new Node(t);
		if (Head == NULL) //Если в списке нет элементов
			Head = to_add;
		else
		{
			Node* current;
			for (current = Head; current->Next != 0; current = current->Next);
			current->Next = to_add;
		}
		count++;
		to_add->l.Add( month,  hour,  day, data);
		return count;
	}


	void Show()
	{
		Node* temp = Head;
		while (temp != NULL) // Просматриваем весь список.
		{
			cout << temp->t << ":\t" << "\n";
			temp->l.Show();
			temp = temp->Next;
		}
	}
	void ShowPer(unsigned int t, string month, string hour, unsigned int day)
	{
		Node* temp = Head;
		while (temp != NULL) // Просматриваем весь список.
		{
			if (temp->t == t)
			{
				cout << temp->t << ":\t" << "\n";
				temp->l.ShowPer(month,hour,day);
				temp = temp->Next;
				
			}else 
				temp = temp->Next;
		}
	}

	void clear() //Очистка списка
	{
		Node* current = Head;
		Node* to_del = Head;
		while (to_del != NULL)
		{
			current = current->Next;
			delete to_del;
			to_del = current;
		}
		Head = NULL;
		count = 0;
	}
	 


};




void main()
{


	int choice;
	ListY Year;
	unsigned int  year, day;
	string  month,  hour,data;
	do {
		cout << "Select option:" << endl << "1.To add new entry" << endl << "2.View at all records" << endl << "3.View record for a specific period" << endl;
		cin >> choice;
		cout << endl;
		switch (choice)
		{
		case 1:
			cout << "Year: ";
			cin >> year;
			cout << "Month: ";
			cin >> month;
			cout << "Day: ";
			cin >> day;
			cout << "Hour: ";
			cin >> hour;
			cout << "Data: ";
			cin.ignore();
			getline(cin, data);
			Year.Add(year, month, hour, day, data);
			cout << endl << endl; break;

		case 2:Year.Show(); cout << endl<<endl; break;
		case 3:
			cout << "Year: ";
			cin >> year;
			cout << "Month: ";
			cin >> month;
			cout << "Day: ";
			cin >> day;
			cout << "Hour: ";
			cin >> hour;
			cout << endl << endl;
			Year.ShowPer(year, month, hour, day);
			cout << endl << endl; break;
		}

	} while (choice != 5);
}