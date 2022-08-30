#pragma once
template <typename T>
class List
{

	class Node
	{
	public:
		T Val;
		Node* Next = nullptr;// *Prev = nullptr;

	};
	int count=0;
	Node* Head = nullptr;//, * Tail =nullptr;
public:
	List() :Head(NULL), count(0) {};//Tail(NULL), 
	~List()
	{
		while (Head)
		{
			Node* temp = Head->Next;
			//Tail = Head->Next;
			delete Head;
			//Head = Tail;
			Head = temp;
		}
	}
	List(const List& other)
	{
		count = 0;
		Head =  NULL;
		Node* temp = new Node;

		temp = other.Head;
		while (temp != 0)
		{
			this->Add(temp->Val);
			temp = temp->Next;

		}
	}

	friend ostream& operator<<(ostream& cout, const List& obj) {
		int size = obj.count;
		if (size) {
			Node* tmp = obj.Head;
			for (int i = 0; i < size; i++, tmp = tmp->Next) {
				cout <<tmp->Val<<endl<<endl;
			}
		}
		return cout;
	}




	void AddToEnd(T Val)
	{
		Node* temp = new Node;
		temp->Next = NULL;// temp->Prev = NULL; 
		temp->Val = Val;
		count++;
		if (Head != NULL)
		{

			Node* cur = Head;
			while (cur->Next)
			{

				cur = cur->Next;
			}
			if (!cur->Next)
				cur->Next = temp;
			//temp->Prev = Tail;
			//Tail->Next = temp;
			//Tail = temp;
		}
		else
		{
			//temp->Prev = NULL;
			Head = temp;
			//Head = Tail = temp;
		}
	}

	void AddToBeg(T Val)
	{
		Node* temp = new Node; // Создаем новый элемент.
		temp->Next = NULL; // Обнуляем его указатель на следующий.
		temp->Val = Val;
		count++;
		if (Head != NULL)
		{
			Node* tHead = Head;
			Head = temp;
			Head->Next = tHead;
			
		}
		else
		{
			
			Head =  temp;
		}

	}

	void AddAft(T Val, int pos)
	{
		Node* to_add = new Node;
		to_add->Val = Val;
		if (Head == NULL)
			Head = to_add;
		else
		{
			Node* current = Head;
			Node* temp;
			for (int i = 1; i < pos; i++)
				current = current->Next;
			temp = current->Next;
			current->Next = to_add;
			to_add->Next = temp;
		}
		count++;
		
	}


	void fill(string name)
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

				AddToEnd(temp);

			}
		}
		else
			cout << "File not found" << endl;

		file.close();

	}
	/*void clear()
	{
		while (Head)
		{
			Node* next = Head->Next;
			delete Head;
			Head = next;
		}
		count = 0;
	}*/

	int del(int x)
	{			   //Возвращает -1, если произошла ошибка
		if (x > count) return -1;
		Node* to_del = Head;
		if (x == 1) //Если нужно удалить первый элемент
		{
			Head = Head->Next;
			delete to_del;
		}
		else
		{
			Node* current = Head;
			for (int i = 1; i < x - 1; i++)
				current = current->Next;
			to_del = current->Next;
			current->Next = current->Next->Next;
			delete to_del;
		}
		count--;
		return count;
	}

	T min()
	{
		Node* tmp = Head->Next;
		T min = Head->Val;
		for (int i = 0; i < count - 1; i++, tmp = tmp->Next) {
			if (min > tmp->Val)
				min = tmp->Val;
		}
		return min;
	}


	int getSize()
	{
		return count;
	}

};