#define _CRT_SECURE_NO_WARNINGS
#include <iostream>
using namespace std;

struct Node
{
	int position;
	double data;
	Node* Next, * Prev;
};

class List
{
	Node* Head, * Tail; 

public:
	List() :Head(NULL), Tail(NULL) {}; 
	~List()
	{
		while (Head) // До тех пор, пока головной элемент не равен NULL
		{
			Tail = Head->Next; // Переопределяем хвост
			delete Head;// Удаляем голову
			Head = Tail;// Определяем новую голову
		}
	}

	void Delete(int position)
	{
		bool flag = false;
		Node* current = Head;
		while (!flag)
		{
			if (current->position != position)
				current = current->Next;
			else
			{
				if (current->Next == NULL)
				{
					flag = true;
					current->Prev->Next = NULL;
					Tail = current->Prev;
					delete current;
				}
				else if (current->Prev == NULL)
				{
					flag = true;
					current->Next->Prev = NULL;
					Head = current->Next;
					delete current;
				}
				else

				{
					flag = true;
					current->Prev->Next = current->Next;
					current->Next->Prev = current->Prev;
					delete current;
				}

			}
		}
			
		
	}

	void Add(double data,int position)
	{
		Node* temp = new Node; // Создаем новый элемент.
		temp->Next = temp->Prev = NULL; // Обнуляем его указатель на следующий.
		temp->data = data; 
		temp->position = position;
		if (Head != NULL)
		{
			temp->Prev = Tail;
			Tail->Next = temp;
			Tail = temp;
		}
		else
		{
			temp->Prev = NULL;
			Head = Tail = temp;
		}
	}
	void Show()
	{
		Node* temp = Head;
		while (temp!= NULL) // Просматриваем весь список.
		{
			cout <<"Element-"<< temp->data<<"\t" << "Position-"<<temp->position<<"\n";
			temp = temp->Next;
		}
	}
	int save(int position)
	{
		Node* temp = Head;
		while(position!=temp->position)
			temp = temp->Next;
		return temp->data;
	}
	
	
};

void main()
{
	int last,p;
	double d;
	List List;
	cout << "Enter number of elements: ";
	cin >> last;
	int* arr = new int[last];
	for (int i = 0; i < last; i++)
	{
		cout << "Element: ";
		cin >> d;
		cout << "Position: ";
		cin >> p;
		List.Add(d, p);
		arr[p-1] = List.save(p);

	}
	List.Show();
	cout << endl;
	for (int i = 0; i < last; i++)
	{
		cout << arr[i] << "\t";
	}
	cout << endl;
	List.Delete(3);
	cout << endl;
	List.Show();
	cout << endl;
	delete(arr);
	
}