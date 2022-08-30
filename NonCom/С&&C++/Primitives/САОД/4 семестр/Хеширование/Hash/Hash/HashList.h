#pragma once

template <typename T>
class VList;


template <typename T>
class VList
{
	class node
	{

	public:
		//friend ostream& operator<< <T>(ostream& out, const VList<T>& obj);
		node* next = nullptr, * prev = nullptr;
		T val; //Данные списка
		node() : next(NULL), prev(NULL) {}
		node(T data) : next(NULL), prev(NULL), val(data) {}

		~node() {}

		ostream& operator << (ostream& out)
		{

			out << val << endl << endl;
			return out;

		}
	};
	node* head = nullptr, * tail = nullptr;
	int count;
public:
	//	friend ostream& operator<< <T>(ostream& out, const VList<T>& obj);

	VList()
	{
		this->head = nullptr;
		this->tail = nullptr;
		this->count = 0;
	}
	VList(const VList& other)
	{
		count = 0;
		head = tail = NULL;
		node* temp = new node;

		temp = other.head;
		while (temp != 0)
		{
			this->AddToEnd(temp->val);
			temp = temp->next;

		}
	}


	void clear()
	{
		node* current = head;
		node* to_del = head;
		while (to_del != NULL)
		{
			current = current->next;
			delete to_del;
			to_del = current;
		}
		head = NULL;
		count = 0;
	}

	int getCount() const
	{
		return count;
	}

	node* begin()
	{
		return head;
	}
	node* end()
	{
		return tail;
	}


	int AddToEnd(T data)
	{
		node* to_add = new node;
		to_add->next = to_add->prev = NULL;
		to_add->val = data;
		if (head != NULL)
		{
			to_add->prev = tail;
			tail->next = to_add;
			tail = to_add;
		}
		else
		{
			to_add->prev = NULL;
			head = tail = to_add;
		}

		count++;
		return count;
	}


	int AddToBeg(T data)
	{
		node* to_add = new node(data);
		if (head == NULL)
			head = to_add;
		else
		{
			node* temp = head;
			head = to_add;
			to_add->next = temp;

		}
		count++;
		return count;
	}


	int AddAft(T data, int x)
	{
		node* to_add = new node(data);
		if (head == NULL)
			head = to_add;
		else
		{
			node* current = head;
			node* temp;
			for (int i = 1; i < x; i++)
				current = current->next;
			temp = current->next;
			current->next = to_add;
			to_add->next = temp;
		}
		count++;
		return count;
	}


	int del(int x)
	{			   //Возвращает -1, если произошла ошибка
		if (x > count) return -1;
		node* to_del = head;
		if (x == 1) //Если нужно удалить первый элемент
		{
			head = head->next;
			delete to_del;
		}
		else
		{
			node* current = head;
			for (int i = 1; i < x - 1; i++)
				current = current->next;
			to_del = current->next;
			current->next = current->next->next;
			delete to_del;
		}
		count--;
		return count;
	}



	T getData(int x) const
	{
		node* current;
		for (current = head; x > 1; x--)
			current = current->next;
		return current->val;
	}

	friend ostream& operator<<(ostream& cout, const VList& obj) {
		int size = obj.count;
		if (size) {
			node* tmp = obj.head;
			for (int i = 0; i < size; i++, tmp = tmp->next) {
				cout << tmp->val << endl;
			}
		}
		return cout;
	}

	void Show()
	{
		node* temp = head;
		for (int i = 0; i < count; i++)
		{
			cout << temp->val << " ; ";
			temp = temp->next;
		}


	}


	T min()
	{
		node* tmp = head->next;
		T min = head->val;
		for (int i = 0; i < count - 1; i++, tmp = tmp->next) {
			if (min > tmp->val)
				min = tmp->val;
		}
		return min;
	}

};