#include "List.h"
using namespace std;
List::List() :Head(NULL), Tail(NULL),count(0) {};
List::~List()
{
	while (Head) // До тех пор, пока головной элемент не равен NULL
	{
		Tail = Head->Next; // Переопределяем хвост
		delete Head;// Удаляем голову
		Head = Tail;// Определяем новую голову
	}
}
List::List(const List& other)
{
	count = 0;
	Head = Tail = NULL;
	Node* temp = new Node;

	temp = other.Head;
	while (temp != 0)
	{
		this->Add(temp->flight);
		temp = temp->Next;
			
	}
}

 


void List::Add(Aeroflot &flight)
{
	Node* temp = new Node; // Создаем новый элемент.
	temp->Next = temp->Prev = NULL; // Обнуляем его указатель на следующий.
	temp->flight.destination = flight.destination;
	temp->flight.num = flight.num;
	temp->flight.time = flight.time;
	temp->flight.type = flight.type;
	temp->flight.date = flight.date;
	count++;
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
void List::Show()
{
	Node* temp = Head;
	while (temp != NULL) // Просматриваем весь список.
	{
		cout << temp;
		//cout << temp->flight.destination << "\t"  << temp->flight.num << "\t"  << temp->flight.time << "\t"  << temp->flight.type << "\t"  << temp->flight.date << "\t" << "\n\n";
		temp = temp->Next;
	}
}

void List::fill(string name)
{
	string destination;
	int num;
	string type;
	double time;
	string date;

	Aeroflot temp;
	ifstream file(name);

	if (file)
	{
		while (!file.eof())
		{

			file >> destination >> num >> type >> time >> date;

			temp.destination = destination; temp.type = type; temp.num = num; temp.time = time; temp.date = date;

			Add(temp);

		}
	}
	else
		cout << "File not found" << endl;

	file.close();
	
}
void List::clear()
{
	while (Head)
	{
		Node* next = Head->Next;
		delete Head;
		Head = next;
	}
	count = 0;
}

int List::getSize()
{
	return count;
}








/*void List::Delete(int position)
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


}*/
